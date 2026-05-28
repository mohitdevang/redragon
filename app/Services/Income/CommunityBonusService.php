<?php

namespace App\Services\Income;

use App\Models\User;
use App\Services\Wallet\WalletService;
use App\Support\IncomeEngine;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommunityBonusService
{
    public function __construct(
        protected WalletService $wallets
    ) {}

    public function run(string $idempotencyDate = null): bool
    {
        if (! IncomeEngine::enabled()) {
            return false;
        }

        $runDate = $idempotencyDate ?: date('Y-m-d');
        $jobKey = 'community_bonus';

        if (DB::table('cron_run_logs')->where(['job_key' => $jobKey, 'run_date' => $runDate])->exists()) {
            return false;
        }

        return DB::transaction(function () use ($jobKey, $runDate) {
            DB::table('cron_run_logs')->insert([
                'job_key' => $jobKey,
                'run_date' => $runDate,
                'status' => 'running',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $wallets = DB::table('wallet_community')->where('balance', '>', 0)->lockForUpdate()->get();

            foreach ($wallets as $wall) {
                $amount = round((float) $wall->balance * 0.01, 2);
                if ($amount <= 0) {
                    continue;
                }

                DB::table('wallet_community_history')->insert([
                    'user_id' => $wall->user_id,
                    'balance' => $wall->balance,
                    'updated_at' => $runDate,
                ]);

                $this->distributeSerial($wall->user_id, 50, $amount, 'community-upline', '<');
                $this->distributeSerial($wall->user_id, 50, $amount, 'community-downline', '>');

                DB::table('wallet_community')->where('user_id', $wall->user_id)->update(['balance' => 0]);
            }

            DB::table('cron_run_logs')->where(['job_key' => $jobKey, 'run_date' => $runDate])->update([
                'status' => 'completed',
                'updated_at' => now(),
            ]);

            return true;
        });
    }

    protected function distributeSerial(
        string $payerUserId,
        int $limit,
        float $amount,
        string $rank,
        string $direction
    ): void {
        $payer = User::where('unique_id', $payerUserId)->first();
        if (! $payer || ! $payer->registration_serial) {
            return;
        }

        $query = User::query()
            ->whereNotNull('registration_serial')
            ->where('status', 'active');
        if ($direction === '<') {
            $query->where('registration_serial', '<', $payer->registration_serial)
                ->orderByDesc('registration_serial');
        } else {
            $query->where('registration_serial', '>', $payer->registration_serial)
                ->orderBy('registration_serial');
        }

        $recipients = $query->limit($limit)->get();
        $slno = 1;

        foreach ($recipients as $recipient) {
            $exist = DB::table('commision_community')->where([
                ['member_id', $recipient->unique_id],
                ['created_date', date('Y-m-d')],
                ['direct_member_id', $payerUserId],
                ['rank', $rank],
            ])->first();

            if ($exist) {
                $slno++;
                continue;
            }

            $rowId = DB::table('commision_community')->insertGetId([
                'member_id' => $recipient->unique_id,
                'plan' => 0,
                'rank' => $rank,
                'level' => $slno,
                'target' => 0,
                'type' => 'credit',
                'amount' => $amount,
                'taxable_amount' => $amount,
                'created_date' => date('Y-m-d'),
                'in_wallet' => 0,
                'income_type' => 'community',
                'direct_member_id' => $payerUserId,
            ]);

            $this->wallets->credit(
                $recipient->unique_id,
                WalletService::PRIMARY,
                $amount,
                [
                    'income_type' => 'community',
                    'transaction_type' => 'community_bonus',
                    'source_user_id' => $payerUserId,
                    'reference_type' => 'commision_community',
                    'reference_id' => $rowId,
                    'remarks' => $rank,
                ],
                'community:'.$recipient->unique_id.':'.date('Y-m-d').':'.$payerUserId.':'.$rank.':'.$slno
            );

            $slno++;
            if ($slno > $limit) {
                break;
            }
        }
    }
}
