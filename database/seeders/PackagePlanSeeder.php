<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Magic Pool 01–10 aligned to Red Dragon compensation PDF.
 * Run: php artisan db:seed --class=PackagePlanSeeder
 *
 * Package id 11 ("1024 MAJIC POOL 10") is legacy test data — deactivated, not seeded.
 */
class PackagePlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            // PDF Pool 01: L1 entry 3, L2 entry 3, L3 entry 6 | total entry fee 10 | rebirth 10 | profit 3/6/38
            ['id' => 1, 'package_name' => 'Magic Pool 01', 'price' => 10, 'entry_fee_level_1' => 3, 'entry_fee_level_2' => 3, 'entry_fee_level_3' => 6, 'upgrade_charge' => 3, 're_birth_chrage' => 10, 'profit_level_1' => 3, 'profit_level_2' => 6, 'profit_level_3' => 38],
            ['id' => 2, 'package_name' => 'Magic Pool 02', 'price' => 30, 'entry_fee_level_1' => 9, 'entry_fee_level_2' => 9, 'entry_fee_level_3' => 18, 'upgrade_charge' => 9, 're_birth_chrage' => 30, 'profit_level_1' => 9, 'profit_level_2' => 18, 'profit_level_3' => 114],
            ['id' => 3, 'package_name' => 'Magic Pool 03', 'price' => 90, 'entry_fee_level_1' => 27, 'entry_fee_level_2' => 27, 'entry_fee_level_3' => 54, 'upgrade_charge' => 27, 're_birth_chrage' => 90, 'profit_level_1' => 27, 'profit_level_2' => 54, 'profit_level_3' => 342],
            ['id' => 4, 'package_name' => 'Magic Pool 04', 'price' => 270, 'entry_fee_level_1' => 81, 'entry_fee_level_2' => 81, 'entry_fee_level_3' => 162, 'upgrade_charge' => 81, 're_birth_chrage' => 270, 'profit_level_1' => 81, 'profit_level_2' => 162, 'profit_level_3' => 1269],
            ['id' => 5, 'package_name' => 'Magic Pool 05', 'price' => 810, 'entry_fee_level_1' => 243, 'entry_fee_level_2' => 243, 'entry_fee_level_3' => 486, 'upgrade_charge' => 243, 're_birth_chrage' => 810, 'profit_level_1' => 243, 'profit_level_2' => 486, 'profit_level_3' => 3078],
            ['id' => 6, 'package_name' => 'Magic Pool 06', 'price' => 2430, 'entry_fee_level_1' => 729, 'entry_fee_level_2' => 729, 'entry_fee_level_3' => 1458, 'upgrade_charge' => 729, 're_birth_chrage' => 2430, 'profit_level_1' => 729, 'profit_level_2' => 1458, 'profit_level_3' => 9234],
            ['id' => 7, 'package_name' => 'Magic Pool 07', 'price' => 7290, 'entry_fee_level_1' => 2187, 'entry_fee_level_2' => 2187, 'entry_fee_level_3' => 4374, 'upgrade_charge' => 2187, 're_birth_chrage' => 7290, 'profit_level_1' => 2187, 'profit_level_2' => 4374, 'profit_level_3' => 27702],
            ['id' => 8, 'package_name' => 'Magic Pool 08', 'price' => 21870, 'entry_fee_level_1' => 6561, 'entry_fee_level_2' => 6561, 'entry_fee_level_3' => 13122, 'upgrade_charge' => 6561, 're_birth_chrage' => 21870, 'profit_level_1' => 6561, 'profit_level_2' => 13122, 'profit_level_3' => 83106],
            ['id' => 9, 'package_name' => 'Magic Pool 09', 'price' => 65610, 'entry_fee_level_1' => 19683, 'entry_fee_level_2' => 19683, 'entry_fee_level_3' => 39366, 'upgrade_charge' => 19683, 're_birth_chrage' => 65610, 'profit_level_1' => 19683, 'profit_level_2' => 39366, 'profit_level_3' => 249318],
            ['id' => 10, 'package_name' => 'Magic Pool 10', 'price' => 196830, 'entry_fee_level_1' => 59049, 'entry_fee_level_2' => 59049, 'entry_fee_level_3' => 118098, 'upgrade_charge' => 59049, 're_birth_chrage' => 196830, 'profit_level_1' => 59049, 'profit_level_2' => 118098, 'profit_level_3' => 747954],
        ];

        foreach ($plans as $plan) {
            DB::table('package')->updateOrInsert(
                ['id' => $plan['id']],
                array_merge($plan, [
                    'level_1_team' => 2,
                    'level_2_team' => 4,
                    'level_3_team' => 8,
                    'magic_pool' => 1,
                    'status' => 'active',
                ])
            );
        }

        // Legacy row: not in PDF (PDF Pool 10 = id 10 @ 196830 USDT). No users assigned; hide from activation.
        if (DB::table('package')->where('id', 11)->exists()) {
            DB::table('package')->where('id', 11)->update([
                'status' => 'inactive',
                'package_name' => '1024 MAJIC POOL 10 (legacy)',
            ]);
        }
    }
}
