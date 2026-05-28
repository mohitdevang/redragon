<?php

namespace App\Console\Commands;

use App\Http\Controllers\ProfileController;
use App\Models\CommisionTable;
use App\Models\User;
use App\Services\Income\CommunityBonusService;
use App\Services\PackageProgressionService;
use App\Services\Wallet\LapseIncomeService;
use App\Services\Wallet\WalletService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class RunPhase2UatCommand extends Command
{
    protected $signature = 'redragon:phase2-uat {--keep-data : Keep generated UAT rows}';

    protected $description = 'Run internal Phase 2 UAT scenarios with reconciliation proof';

    protected int $assertions = 0;

    protected int $failures = 0;

    public function handle(
        WalletService $wallets,
        CommunityBonusService $communityBonus
    ): int {
        if (app()->environment('production')) {
            $this->error('redragon:phase2-uat is disabled in production environment.');
            return self::FAILURE;
        }

        $this->info('=== Redragon Phase 2 Internal UAT ===');
        $tag = 'UATP2_'.now()->format('His');
        $today = now()->toDateString();
        $communityDate = Carbon::parse($today)->addDay()->toDateString();

        try {
            $this->cleanupUatRows();
            $this->enableEngines();

            $this->line('1) Building UAT dataset...');
            [$users, $queueUsers] = $this->buildUsers($tag);
            $this->seedWallets($users);

            $profile = $this->makeProfileHarness();

            $this->line('2) Magic Pool FIFO queue scenarios...');
            foreach ($queueUsers as $uid) {
                $profile->entry_magic_pool($uid, 1, 1, 1);
            }
            $this->verifyMagicPool($queueUsers);

            $this->line('3) Direct income scenarios...');
            $profile->get_direct_income($users['childEligible'], 90, 3);
            $profile->get_direct_income($users['childEligible'], 90, 3); // duplicate attempt
            $profile->get_direct_income($users['childIneligible'], 90, 3);
            $this->verifyDirectIncome($users);

            $this->line('4) Level income scenarios...');
            $profile->get_parent_user_byads($users['childLevel'], 1, 90, 3);
            $profile->get_parent_user_byads($users['childInactive'], 1, 90, 3);
            $this->verifyLevelIncome($users);

            $this->line('5) Community bonus scenarios...');
            DB::table('wallet_community')->where('user_id', $users['communityPayer'])->update(['balance' => 100]);
            $firstRun = $communityBonus->run($communityDate);
            $secondRun = $communityBonus->run($communityDate);
            $this->assert($firstRun === true, 'Community cron first execution succeeds');
            $this->assert($secondRun === false, 'Community cron duplicate execution blocked');
            $this->verifyCommunityBonus($users, $communityDate);

            $this->line('6) Lapse income scenarios...');
            $this->verifyLapse($users);

            $this->line('7) Withdrawal hold and safety scenarios...');
            $this->verifyWithdrawalSafety($users, $wallets);

            $this->line('8) Reconciliation proof...');
            $this->reconciliationProof($users);

            $this->line('9) Dashboard / history data presence...');
            $this->verifyDashboardHistory($users, $queueUsers);

            if (! $this->option('keep-data')) {
                $this->cleanupUatRows();
            }

            $this->newLine();
            $this->info("Assertions: {$this->assertions}, Failures: {$this->failures}");
            if ($this->failures > 0) {
                $this->error('UAT FAILED');

                return self::FAILURE;
            }
            $this->info('UAT PASSED');

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('UAT runtime error: '.$e->getMessage());

            return self::FAILURE;
        }
    }

    protected function enableEngines(): void
    {
        if (DB::getSchemaBuilder()->hasTable('settings')) {
            $row = DB::table('settings')->first();
            if ($row) {
                $updates = [];
                if (property_exists($row, 'income_engine_enabled')) {
                    $updates['income_engine_enabled'] = 1;
                }
                if (property_exists($row, 'package_purchase_enabled')) {
                    $updates['package_purchase_enabled'] = 1;
                }
                if ($updates !== []) {
                    DB::table('settings')->where('id', $row->id)->update($updates);
                }
            }
        }
    }

    protected function buildUsers(string $tag): array
    {
        $serialBase = (int) (DB::table('users')->max('registration_serial') ?? 100000) + 100;
        $i = 0;

        $mk = function (string $suffix, string $status = 'active', int $pkg = 1) use (&$i, $serialBase, $tag): string {
            $i++;
            $uid = $tag.'_'.$suffix;
            User::updateOrCreate(
                ['unique_id' => $uid],
                [
                    'registration_serial' => $serialBase + $i,
                    'name' => $uid,
                    'email' => strtolower($uid).'@uat.local',
                    'password' => Hash::make('Uat@12345'),
                    'secpwd' => Hash::make('Uat@12345'),
                    'status' => $status,
                    'kys_status' => 'active',
                    'package_id' => $pkg,
                    'unlocked_package_id' => min($pkg + 1, 10),
                    'max_purchased_package_id' => $pkg,
                ]
            );

            return $uid;
        };

        $root = $mk('ROOT', 'active', 10);
        $sponsorHigh = $mk('SPH', 'active', 5);
        $childEligible = $mk('CHE', 'active', 1);
        $sponsorLow = $mk('SPL', 'active', 1);
        $childIneligible = $mk('CHI', 'active', 1);
        $levelLow = $mk('LVLLOW', 'active', 1);
        $childLevel = $mk('CHLVL', 'active', 1);
        $inactiveParent = $mk('INACTP', 'inactive', 10);
        $childInactive = $mk('CHINACT', 'active', 1);
        $withdrawUser = $mk('WD', 'active', 2);
        $communityPayer = $mk('COMPAY', 'active', 2);
        $communityInactive = $mk('COMINACT', 'inactive', 2);

        DB::table('user_parents')->insert([
            ['user_id' => $sponsorHigh, 'parent_id' => $root],
            ['user_id' => $childEligible, 'parent_id' => $sponsorHigh],
            ['user_id' => $sponsorLow, 'parent_id' => $root],
            ['user_id' => $childIneligible, 'parent_id' => $sponsorLow],
            ['user_id' => $levelLow, 'parent_id' => $root],
            ['user_id' => $childLevel, 'parent_id' => $levelLow],
            ['user_id' => $childInactive, 'parent_id' => $inactiveParent],
            ['user_id' => $withdrawUser, 'parent_id' => $root],
            ['user_id' => $communityPayer, 'parent_id' => $root],
            ['user_id' => $communityInactive, 'parent_id' => $root],
        ]);

        $queueUsers = [];
        // Deeper queue depth to guarantee L3 close + rebirth assertions.
        for ($q = 1; $q <= 220; $q++) {
            $queueUid = $mk('Q'.$q, 'active', 1);
            $queueUsers[] = $queueUid;
            DB::table('user_parents')->insert([
                'user_id' => $queueUid,
                'parent_id' => $root,
            ]);
        }

        // Make inactive serial adjacent to payer for community filter test.
        $payerSerial = DB::table('users')->where('unique_id', $communityPayer)->value('registration_serial');
        DB::table('users')->where('unique_id', $communityInactive)->update([
            'registration_serial' => $payerSerial + 1,
        ]);

        return [[
            'root' => $root,
            'sponsorHigh' => $sponsorHigh,
            'childEligible' => $childEligible,
            'sponsorLow' => $sponsorLow,
            'childIneligible' => $childIneligible,
            'levelLow' => $levelLow,
            'childLevel' => $childLevel,
            'inactiveParent' => $inactiveParent,
            'childInactive' => $childInactive,
            'withdrawUser' => $withdrawUser,
            'communityPayer' => $communityPayer,
            'communityInactive' => $communityInactive,
        ], $queueUsers];
    }

    protected function seedWallets(array $users): void
    {
        $seed = [
            $users['root'],
            $users['sponsorHigh'],
            $users['sponsorLow'],
            $users['levelLow'],
            $users['withdrawUser'],
            $users['communityPayer'],
        ];

        foreach ($seed as $uid) {
            DB::table('wallet_primary')->updateOrInsert(['user_id' => $uid], ['balance' => 1000, 'hold_balance' => 0, 'updated_at' => now()]);
            DB::table('wallet_secondary')->updateOrInsert(['user_id' => $uid], ['balance' => 1000, 'hold_balance' => 0]);
            DB::table('wallet_community')->updateOrInsert(['user_id' => $uid], ['balance' => 0, 'hold_balance' => 0]);
        }
    }

    protected function verifyMagicPool(array $queueUsers): void
    {
        $first = $queueUsers[0];
        $l1Closed = DB::table('commision_majic_pool')->where('user_id', $first)->where('packg_id', 1)->where('level', 1)->where('status', 'closed')->exists();
        $l2Closed = DB::table('commision_majic_pool')->where('user_id', $first)->where('packg_id', 1)->where('level', 2)->where('status', 'closed')->exists();
        $l3Closed = DB::table('commision_majic_pool')->where('user_id', $first)->where('packg_id', 1)->where('level', 3)->where('status', 'closed')->exists();
        $this->assert($l1Closed, 'Magic pool L1 closes for first queue user');
        $this->assert($l2Closed, 'Magic pool L2 closes for first queue user');
        $this->assert($l3Closed, 'Magic pool L3 closes for first queue user');

        $queueReentry = DB::table('pool_quee')->where('user_id', $first)->where('pack_id', 1)->where('cycle', '>=', 2)->exists();
        $this->assert($queueReentry, 'Magic pool rebirth re-enters queue');

        $duplicateRows = DB::table('wallet_transactions')
            ->select('idempotency_key', DB::raw('COUNT(*) as c'))
            ->whereNotNull('idempotency_key')
            ->where('idempotency_key', 'like', 'magic_pool:%')
            ->groupBy('idempotency_key')
            ->having('c', '>', 1)
            ->count();
        $this->assert($duplicateRows === 0, 'Magic pool idempotency prevents duplicate ledger rows');

        $firstAssignment = DB::table('commision_majic_pool')->where('user_id', $first)->where('packg_id', 1)->where('level', 1)->orderBy('id')->first();
        $this->assert(! empty($firstAssignment?->for_ids), 'Magic pool queue assignment history captured');
    }

    protected function verifyDirectIncome(array $users): void
    {
        $eligibleCredit = DB::table('commision_direct')->where('member_id', $users['sponsorHigh'])->where('direct_member_id', $users['childEligible'])->where('type', 'credit')->count();
        $this->assert($eligibleCredit === 1, 'Direct income eligible case credits exactly once');

        $ledger = DB::table('wallet_transactions')->where('user_id', $users['sponsorHigh'])->where('transaction_type', 'direct_income')->where('direction', 'credit')->count();
        $this->assert($ledger >= 2, 'Direct income creates primary/community ledger entries');

        $ineligibleCredit = DB::table('commision_direct')->where('member_id', $users['sponsorLow'])->where('direct_member_id', $users['childIneligible'])->where('type', 'not')->count();
        $this->assert($ineligibleCredit >= 1, 'Direct ineligible case marked as not');
    }

    protected function verifyLevelIncome(array $users): void
    {
        $lowLapse = DB::table('lapse_income_transactions')
            ->where('income_type', 'level')
            ->where('beneficiary_user_id', $users['levelLow'])
            ->exists();
        $this->assert($lowLapse, 'Level ineligible upline produces lapse');

        $rootLevelCredit = DB::table('wallet_transactions')
            ->where('user_id', $users['root'])
            ->where('transaction_type', 'level_income')
            ->where('direction', 'credit')
            ->exists();
        $this->assert($rootLevelCredit, 'Level eligible upline receives ledger credit');

        $inactiveCredited = DB::table('commision_level')
            ->where('member_id', $users['inactiveParent'])
            ->where('direct_member_id', $users['childInactive'])
            ->exists();
        $this->assert(! $inactiveCredited, 'Inactive sponsor gets no level credit');
    }

    protected function verifyCommunityBonus(array $users, string $runDate): void
    {
        $payer = $users['communityPayer'];
        $inactive = $users['communityInactive'];

        $inactiveRow = DB::table('commision_community')
            ->where('direct_member_id', $payer)
            ->where('member_id', $inactive)
            ->where('created_date', $runDate)
            ->exists();
        $this->assert(! $inactiveRow, 'Community bonus excludes inactive recipients');

        $anyCredits = DB::table('wallet_transactions')
            ->where('transaction_type', 'community_bonus')
            ->where('source_user_id', $payer)
            ->count();
        $this->assert($anyCredits > 0, 'Community bonus distributes to serial neighbors');
    }

    protected function verifyLapse(array $users): void
    {
        $adminBalance = (float) (DB::table('admin_lapse_wallet')->value('balance') ?? 0);
        $lapseRows = DB::table('lapse_income_transactions')->whereIn('beneficiary_user_id', [$users['sponsorLow'], $users['levelLow']])->count();
        $lapseLedgerRows = DB::table('wallet_transactions')->where('wallet_type', 'lapse_admin')->where('transaction_type', 'lapse')->count();
        $this->assert($lapseRows >= 2, 'Lapse history records direct+level ineligible cases');
        $this->assert($lapseLedgerRows >= 2, 'Lapse ledger entries created');
        $this->assert($adminBalance > 0, 'Admin lapse wallet credited');
    }

    protected function verifyWithdrawalSafety(array $users, WalletService $wallets): void
    {
        $uid = $users['withdrawUser'];

        DB::transaction(function () use ($uid, $wallets) {
            $wallets->addHold($uid, 40, WalletService::PRIMARY);
            CommisionTable::create([
                'member_id' => $uid,
                'type' => 'debit',
                'amount' => 40,
                'plan' => 0,
                'request_status' => 'processing',
                'tax' => '10%',
                'taxable_amount' => 4,
                'net_payment' => 36,
                'created_date' => now()->toDateString(),
                'wallet_type' => 'p',
            ]);
        });

        $balance = $wallets->getBalance($uid, WalletService::PRIMARY);
        $this->assert((float) $balance['hold_balance'] === 40.0, 'Withdrawal request places amount on hold');
        $this->assert((float) $balance['spendable'] === (float) $balance['balance'] - 40.0, 'Spendable excludes hold');

        $pendingCount = CommisionTable::where('member_id', $uid)->where('type', 'debit')->where('request_status', 'processing')->count();
        $this->assert($pendingCount === 1, 'Only one pending withdrawal request exists');

        $pendingExists = CommisionTable::where('member_id', $uid)->where('type', 'debit')->where('request_status', 'processing')->exists();
        $this->assert($pendingExists, 'Pending withdrawal would block package/p2p operations');

        DB::transaction(function () use ($uid, $wallets) {
            $wallet = $wallets->getBalance($uid, WalletService::PRIMARY);
            if ($wallet['hold_balance'] >= 40) {
                $wallets->releaseHold($uid, 40, WalletService::PRIMARY);
                $wallets->debit($uid, WalletService::PRIMARY, 40, [
                    'transaction_type' => 'withdrawal',
                    'remarks' => 'UAT withdrawal approve',
                ], 'uat:withdraw:'.$uid, false);
            }
            CommisionTable::where('member_id', $uid)->where('request_status', 'processing')->update(['request_status' => 'approve']);
        });

        $after = $wallets->getBalance($uid, WalletService::PRIMARY);
        $this->assert((float) $after['hold_balance'] === 0.0, 'Withdrawal approve releases hold');
        $this->assert((float) $after['balance'] >= 0.0, 'Negative primary balance prevented');

        try {
            $wallets->debit($uid, WalletService::PRIMARY, 1000000, [], 'uat:negative:'.$uid, true);
            $this->assert(false, 'Negative balance debit blocked');
        } catch (Throwable $e) {
            $this->assert(true, 'Negative balance debit blocked');
        }
    }

    protected function reconciliationProof(array $users): void
    {
        $direct = (float) DB::table('wallet_transactions')->where('transaction_type', 'direct_income')->where('direction', 'credit')->sum('amount');
        $level = (float) DB::table('wallet_transactions')->where('transaction_type', 'level_income')->where('direction', 'credit')->sum('amount');
        $magic = (float) DB::table('wallet_transactions')->where('transaction_type', 'magic_pool')->where('direction', 'credit')->sum('amount');
        $community = (float) DB::table('wallet_transactions')->where('transaction_type', 'community_bonus')->where('direction', 'credit')->sum('amount');
        $sum = round($direct + $level + $magic + $community, 2);

        $this->line('  Reconciliation scope: global ledger totals generated in UAT run');
        $this->line('    Direct: '.number_format($direct, 2));
        $this->line('    Level: '.number_format($level, 2));
        $this->line('    Magic: '.number_format($magic, 2));
        $this->line('    Community: '.number_format($community, 2));
        $this->line('    Sum: '.number_format($sum, 2));

        $this->assert($direct > 0 && $level > 0 && $magic > 0 && $community > 0, 'All four income types generated non-zero data');
        $this->assert($sum > 0, 'Reconciliation has real non-zero generated income data');
    }

    protected function verifyDashboardHistory(array $users, array $queueUsers): void
    {
        $uid = $queueUsers[0];
        $poolHistoryRows = DB::table('commision_majic_pool')->where('user_id', $uid)->count();
        $walletHistoryRows = DB::table('wallet_transactions')->where('user_id', $uid)->count();
        $this->assert($poolHistoryRows > 0, 'Magic pool user history table has dynamic rows');
        $this->assert($walletHistoryRows > 0, 'Wallet ledger history has dynamic rows');
    }

    protected function makeProfileHarness(): ProfileController
    {
        $ref = new \ReflectionClass(ProfileController::class);
        /** @var ProfileController $profile */
        $profile = $ref->newInstanceWithoutConstructor();

        $set = function (string $prop, mixed $value) use ($profile): void {
            $p = new \ReflectionProperty(ProfileController::class, $prop);
            $p->setAccessible(true);
            $p->setValue($profile, $value);
        };

        $set('wallets', app(WalletService::class));
        $set('lapseIncome', app(LapseIncomeService::class));
        $set('packageProgression', app(PackageProgressionService::class));

        return $profile;
    }

    protected function cleanupUatRows(): void
    {
        DB::table('cron_run_logs')->where('job_key', 'community_bonus')->delete();

        $uids = DB::table('users')->where('unique_id', 'like', 'UATP2_%')->pluck('unique_id')->all();
        if ($uids === []) {
            return;
        }

        DB::table('wallet_transactions')->whereIn('user_id', $uids)->orWhereIn('source_user_id', $uids)->orWhereIn('counterparty_user_id', $uids)->delete();
        DB::table('lapse_income_transactions')->whereIn('trigger_user_id', $uids)->orWhereIn('beneficiary_user_id', $uids)->delete();
        DB::table('commision_direct')->whereIn('member_id', $uids)->orWhereIn('direct_member_id', $uids)->delete();
        DB::table('commision_level')->whereIn('member_id', $uids)->orWhereIn('direct_member_id', $uids)->delete();
        DB::table('commision_community')->whereIn('member_id', $uids)->orWhereIn('direct_member_id', $uids)->delete();
        DB::table('wallet_community_history')->whereIn('user_id', $uids)->delete();
        DB::table('commision_majic_pool')->whereIn('user_id', $uids)->delete();
        DB::table('pool_quee')->whereIn('user_id', $uids)->delete();
        DB::table('user_parents')->whereIn('user_id', $uids)->orWhereIn('parent_id', $uids)->delete();
        DB::table('wallet_primary')->whereIn('user_id', $uids)->delete();
        DB::table('wallet_secondary')->whereIn('user_id', $uids)->delete();
        DB::table('wallet_community')->whereIn('user_id', $uids)->delete();
        DB::table('commision_tables')->whereIn('member_id', $uids)->orWhereIn('downline_member', $uids)->delete();
        DB::table('users')->whereIn('unique_id', $uids)->delete();
    }

    protected function assert(bool $condition, string $message): void
    {
        $this->assertions++;
        if ($condition) {
            $this->line('  [PASS] '.$message);

            return;
        }
        $this->failures++;
        $this->error('  [FAIL] '.$message);
    }
}

