<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PackageProgressionService
{
    public function maxPackageId(): int
    {
        return (int) DB::table('package')->where('status', 'active')->max('id') ?: 10;
    }

    public function nextPurchasablePackageId(User $user): int
    {
        $maxPurchased = (int) ($user->max_purchased_package_id ?? 0);
        if ($maxPurchased === 0) {
            return 1;
        }

        return min($maxPurchased + 1, $this->maxPackageId());
    }

    public function canPurchase(User $user, int $packageId): array
    {
        $package = DB::table('package')->where('id', $packageId)->where('status', 'active')->first();
        if (! $package) {
            return ['allowed' => false, 'message' => 'Selected package is not available.'];
        }

        $nextAllowed = $this->nextPurchasablePackageId($user);
        $maxPurchased = (int) ($user->max_purchased_package_id ?? 0);
        if ($packageId !== $nextAllowed) {
            if ($maxPurchased === 0 && $packageId !== 1) {
                return ['allowed' => false, 'message' => 'Please activate Magic Pool 01 first.'];
            }
            if ($packageId !== $maxPurchased + 1) {
                return [
                    'allowed' => false,
                    'message' => 'Packages must be purchased in order. Next available: Magic Pool '.str_pad((string) $nextAllowed, 2, '0', STR_PAD_LEFT).' ('.$this->packagePrice($nextAllowed).' USDT).',
                ];
            }
        }

        return ['allowed' => true, 'message' => 'OK', 'package' => $package];
    }

    public function packagePrice(int $packageId): float
    {
        return (float) (DB::table('package')->where('id', $packageId)->value('price') ?? 0);
    }

    /**
     * After L3 completion on a package — unlock next package for purchase (does not force upgrade).
     */
    public function unlockNextPackageAfterCycle(User $user, int $completedPackageId): void
    {
        if (! Schema::hasColumn('users', 'unlocked_package_id')) {
            return;
        }

        $next = min($completedPackageId + 1, $this->maxPackageId());
        if ($next > (int) $user->unlocked_package_id) {
            User::where('id', $user->id)->update(['unlocked_package_id' => $next]);
        }
    }

    public function recordPurchase(User $user, int $packageId): void
    {
        $updates = [
            'package_id' => $packageId,
        ];
        if (Schema::hasColumn('users', 'max_purchased_package_id')) {
            $updates['max_purchased_package_id'] = max((int) $user->max_purchased_package_id, $packageId);
        }
        if (Schema::hasColumn('users', 'unlocked_package_id')) {
            $updates['unlocked_package_id'] = min($packageId + 1, $this->maxPackageId());
        }
        User::where('id', $user->id)->update($updates);
    }

    /**
     * @return array<int, array{package: object, eligible: bool, reason: string}>
     */
    public function packagesForUi(User $user): array
    {
        $next = $this->nextPurchasablePackageId($user);
        $package = DB::table('package')->where('status', 'active')->where('id', $next)->first();
        if (! $package) {
            return [];
        }

        return [[
            'package' => $package,
            'eligible' => true,
            'is_next' => true,
            'reason' => '',
        ]];
    }
}
