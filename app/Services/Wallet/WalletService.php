<?php

namespace App\Services\Wallet;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;

class WalletService
{
    public const PRIMARY = 'primary';

    public const SECONDARY = 'secondary';

    public const COMMUNITY = 'community';

    public function tableFor(string $walletType): string
    {
        return match ($walletType) {
            self::PRIMARY => 'wallet_primary',
            self::SECONDARY => 'wallet_secondary',
            self::COMMUNITY => 'wallet_community',
            default => throw new RuntimeException('Unknown wallet type: '.$walletType),
        };
    }

    public function getBalance(string $userId, string $walletType = self::PRIMARY): array
    {
        $table = $this->tableFor($walletType);
        $row = DB::table($table)->where('user_id', $userId)->first();

        $balance = (float) ($row->balance ?? 0);
        $hold = (float) ($row->hold_balance ?? 0);

        return [
            'balance' => $balance,
            'hold_balance' => $hold,
            'spendable' => max(0, $balance - $hold),
        ];
    }

    /**
     * @param  array<string, mixed>  $meta
     */
    public function credit(
        string $userId,
        string $walletType,
        float $amount,
        array $meta = [],
        ?string $idempotencyKey = null
    ): int {
        return $this->applyDelta($userId, $walletType, $amount, 'credit', $meta, $idempotencyKey);
    }

    /**
     * @param  array<string, mixed>  $meta
     */
    public function debit(
        string $userId,
        string $walletType,
        float $amount,
        array $meta = [],
        ?string $idempotencyKey = null,
        bool $respectHold = true
    ): int {
        if ($respectHold && $walletType === self::PRIMARY) {
            $spendable = $this->getBalance($userId, $walletType)['spendable'];
            if ($amount > $spendable) {
                throw new RuntimeException('Insufficient spendable balance.');
            }
        }

        return $this->applyDelta($userId, $walletType, -abs($amount), 'debit', $meta, $idempotencyKey);
    }

    public function addHold(string $userId, float $amount, string $walletType = self::PRIMARY): void
    {
        $table = $this->tableFor($walletType);
        $row = DB::table($table)->where('user_id', $userId)->lockForUpdate()->first();
        if (! $row) {
            throw new RuntimeException('Wallet not found.');
        }
        $balance = (float) $row->balance;
        $holdBefore = (float) ($row->hold_balance ?? 0);
        $holdAfter = $holdBefore + $amount;
        if ($holdAfter > $balance) {
            throw new RuntimeException('Hold amount exceeds available balance.');
        }
        DB::table($table)->where('user_id', $userId)->update(['hold_balance' => $holdAfter]);
    }

    public function releaseHold(string $userId, float $amount, string $walletType = self::PRIMARY): void
    {
        $table = $this->tableFor($walletType);
        $row = DB::table($table)->where('user_id', $userId)->lockForUpdate()->first();
        if (! $row) {
            return;
        }
        $holdBefore = (float) ($row->hold_balance ?? 0);
        $holdAfter = max(0, $holdBefore - $amount);
        DB::table($table)->where('user_id', $userId)->update(['hold_balance' => $holdAfter]);
    }

    /**
     * @param  array<string, mixed>  $meta
     */
    protected function applyDelta(
        string $userId,
        string $walletType,
        float $signedAmount,
        string $direction,
        array $meta,
        ?string $idempotencyKey
    ): int {
        if ($signedAmount == 0.0) {
            return 0;
        }

        if ($idempotencyKey && DB::table('wallet_transactions')->where('idempotency_key', $idempotencyKey)->exists()) {
            return (int) DB::table('wallet_transactions')->where('idempotency_key', $idempotencyKey)->value('id');
        }

        $table = $this->tableFor($walletType);
        $row = DB::table($table)->where('user_id', $userId)->lockForUpdate()->first();

        $balanceBefore = (float) ($row->balance ?? 0);
        $holdBefore = (float) ($row->hold_balance ?? 0);
        $balanceAfter = round($balanceBefore + $signedAmount, 2);

        if ($balanceAfter < 0) {
            throw new RuntimeException('Transaction would cause negative balance.');
        }

        if ($row) {
            DB::table($table)->where('user_id', $userId)->update(['balance' => $balanceAfter]);
        } else {
            $insert = [
                'user_id' => $userId,
                'balance' => $balanceAfter,
            ];
            if (Schema::hasColumn($table, 'hold_balance')) {
                $insert['hold_balance'] = 0;
            }
            if (Schema::hasColumn($table, 'created_at')) {
                $insert['created_at'] = now();
            }
            if (Schema::hasColumn($table, 'updated_at')) {
                $insert['updated_at'] = now();
            }
            DB::table($table)->insert($insert);
        }

        return (int) DB::table('wallet_transactions')->insertGetId([
            'transaction_uid' => (string) Str::uuid(),
            'user_id' => $userId,
            'wallet_type' => $walletType,
            'direction' => $direction,
            'amount' => abs($signedAmount),
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'hold_before' => $holdBefore,
            'hold_after' => $holdBefore,
            'income_type' => $meta['income_type'] ?? null,
            'transaction_type' => $meta['transaction_type'] ?? null,
            'package_id' => $meta['package_id'] ?? null,
            'source_user_id' => $meta['source_user_id'] ?? null,
            'counterparty_user_id' => $meta['counterparty_user_id'] ?? null,
            'reference_type' => $meta['reference_type'] ?? null,
            'reference_id' => $meta['reference_id'] ?? null,
            'idempotency_key' => $idempotencyKey,
            'remarks' => $meta['remarks'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
