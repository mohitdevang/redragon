<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class CommunitySerialMembers
{
    /**
     * Up to $limit members with lower registration serial (joined before this user).
     */
    public static function upline(User $user, int $limit = 50): Collection
    {
        $serial = (int) ($user->registration_serial ?? 0);
        if ($serial <= 0) {
            return collect();
        }

        return User::query()
            ->whereNotNull('registration_serial')
            ->where('registration_serial', '<', $serial)
            ->orderByDesc('registration_serial')
            ->limit($limit)
            ->get(['unique_id', 'name', 'registration_serial', 'status', 'active_date', 'country', 'created_at']);
    }

    /**
     * Up to $limit members with higher registration serial (joined after this user).
     */
    public static function downline(User $user, int $limit = 50): Collection
    {
        $serial = (int) ($user->registration_serial ?? 0);
        if ($serial <= 0) {
            return collect();
        }

        return User::query()
            ->whereNotNull('registration_serial')
            ->where('registration_serial', '>', $serial)
            ->orderBy('registration_serial')
            ->limit($limit)
            ->get(['unique_id', 'name', 'registration_serial', 'status', 'active_date', 'country', 'created_at']);
    }
}
