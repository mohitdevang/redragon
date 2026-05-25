<?php

namespace App\Services;

use App\Models\UserParent;
use Illuminate\Support\Collection;

class LevelPartnerMembers
{
    /**
     * Full downline of a sponsor with MLM depth (Level-1 = direct referrals).
     *
     * @return Collection<int, object> User rows with downline_level (int)
     */
    public static function downlineWithLevels(string $sponsorUniqueId, int $maxDepth = 50): Collection
    {
        $result = collect();
        $frontier = [$sponsorUniqueId];
        $depth = 1;

        while ($depth <= $maxDepth && $frontier !== []) {
            $rows = UserParent::query()
                ->join('users', 'users.unique_id', '=', 'user_parents.user_id')
                ->whereIn('user_parents.parent_id', $frontier)
                ->orderBy('users.created_at')
                ->get([
                    'users.id',
                    'users.unique_id',
                    'users.name',
                    'users.email',
                    'users.phone',
                    'users.country',
                    'users.status',
                    'users.active_date',
                    'users.created_at',
                    'user_parents.parent_id',
                ]);

            if ($rows->isEmpty()) {
                break;
            }

            $nextFrontier = [];

            foreach ($rows as $row) {
                $row->downline_level = $depth;
                $result->push($row);
                $nextFrontier[] = $row->unique_id;
            }

            $frontier = $nextFrontier;
            $depth++;
        }

        return $result;
    }
}
