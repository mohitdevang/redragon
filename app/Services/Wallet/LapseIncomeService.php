<?php

namespace App\Services\Wallet;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LapseIncomeService
{
    public function __construct(
        protected WalletService $wallets
    ) {}

    /**
     * Credit 100% of lapsed amount to admin lapse wallet with full audit trail.
     */
    public function recordLapse(
        string $incomeType,
        float $amount,
        string $triggerUserId,
        string $beneficiaryUserId,
        ?int $packageId,
        string $reason,
        ?string $commissionReferenceType = null,
        ?int $commissionReferenceId = null,
        ?string $idempotencyKey = null
    ): int {
        if ($amount <= 0) {
            return 0;
        }

        $referenceUid = $idempotencyKey ?: (string) Str::uuid();

        if (DB::table('lapse_income_transactions')->where('reference_uid', $referenceUid)->exists()) {
            return (int) DB::table('lapse_income_transactions')->where('reference_uid', $referenceUid)->value('id');
        }

        return DB::transaction(function () use (
            $incomeType,
            $amount,
            $triggerUserId,
            $beneficiaryUserId,
            $packageId,
            $reason,
            $commissionReferenceType,
            $commissionReferenceId,
            $referenceUid
        ) {
            $admin = DB::table('admin_lapse_wallet')->lockForUpdate()->first();
            $balanceBefore = (float) ($admin->balance ?? 0);
            $balanceAfter = round($balanceBefore + $amount, 2);

            DB::table('admin_lapse_wallet')->where('id', $admin->id)->update([
                'balance' => $balanceAfter,
                'updated_at' => now(),
            ]);

            $walletTxId = (int) DB::table('wallet_transactions')->insertGetId([
                'transaction_uid' => (string) Str::uuid(),
                'user_id' => null,
                'wallet_type' => 'lapse_admin',
                'direction' => 'credit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'hold_before' => 0,
                'hold_after' => 0,
                'income_type' => $incomeType,
                'transaction_type' => 'lapse',
                'package_id' => $packageId,
                'source_user_id' => $triggerUserId,
                'counterparty_user_id' => $beneficiaryUserId,
                'reference_type' => $commissionReferenceType,
                'reference_id' => $commissionReferenceId,
                'idempotency_key' => 'lapse:'.$referenceUid,
                'remarks' => $reason,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return (int) DB::table('lapse_income_transactions')->insertGetId([
                'reference_uid' => $referenceUid,
                'income_type' => $incomeType,
                'amount' => $amount,
                'trigger_user_id' => $triggerUserId,
                'beneficiary_user_id' => $beneficiaryUserId,
                'package_id' => $packageId,
                'reason' => $reason,
                'status' => 'credited',
                'wallet_transaction_id' => $walletTxId,
                'commission_reference_id' => $commissionReferenceId,
                'commission_reference_type' => $commissionReferenceType,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    public function totalLapseIncome(): float
    {
        return (float) DB::table('lapse_income_transactions')->sum('amount');
    }
}
