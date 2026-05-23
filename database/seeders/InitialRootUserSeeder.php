<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use App\Models\UserParent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * Creates the first member (root sponsor) so new registrations can use a valid Sponsor ID.
 *
 * Default sponsor ID: RED0001
 * Run after countries: php artisan db:seed --class=InitialRootUserSeeder --force
 */
class InitialRootUserSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('users')) {
            $this->command?->warn('users table not found — skip InitialRootUserSeeder.');

            return;
        }

        $uniqueId = (string) env('ROOT_SPONSOR_ID', 'RED0001');

        if (User::where('unique_id', $uniqueId)->exists()) {
            $this->command?->info("Root sponsor already exists (Sponsor ID: {$uniqueId}).");

            return;
        }

        if (User::query()->exists()) {
            $this->command?->warn(
                'Other users already exist. This seeder only runs on an empty users table. '.
                'Use Sponsor ID of an existing member, or truncate users first.'
            );

            return;
        }

        $country = Country::where('iso_code', env('ROOT_USER_COUNTRY_ISO', 'IN'))->first()
            ?? Country::query()->where('status', true)->orderBy('name')->first();

        $plainPassword = (string) env('ROOT_USER_PASSWORD', 'Redragon@123');
        $dialCode = $country?->dial_code ? \App\Support\CountryDial::normalize($country->dial_code) : '+91';

        $attributes = [
            'unique_id' => $uniqueId,
            'registration_serial' => 1,
            'seq_pin' => 'RD'.date('Hi'),
            'name' => env('ROOT_USER_NAME', 'Red Dragon Root'),
            'email' => env('ROOT_USER_EMAIL', 'root@redragon.local'),
            'phone' => preg_replace('/\D+/', '', (string) env('ROOT_USER_PHONE', '9000000001')),
            'dial_code' => $dialCode,
            'country_id' => $country?->id,
            'country' => $country?->name ?? 'India',
            'adhar_no' => env('ROOT_USER_ADHAR', '000000000000'),
            'password' => Hash::make($plainPassword),
            'secpwd' => $plainPassword,
            'status' => 'active',
            'active_date' => now(),
            'expire_date' => '2099-12-31 23:59:59',
            'email_verified_at' => now(),
            'kys_status' => 'active',
            'invest_amount' => 0,
            'income_limit' => 0,
            'package_id' => 0,
            'current_plan_id' => 0,
        ];

        $attributes = collect($attributes)
            ->filter(fn ($value, $column) => Schema::hasColumn('users', $column))
            ->all();

        $user = User::create($attributes);

        if (Schema::hasTable('user_parents')) {
            $parentRow = [
                'user_id' => $user->unique_id,
                'parent_id' => 0,
            ];
            if (Schema::hasColumn('user_parents', 'created_at')) {
                $parentRow['created_at'] = now();
                $parentRow['updated_at'] = now();
            }
            UserParent::query()->create($parentRow);
        }

        $this->seedWallets($user->unique_id);

        $this->command?->newLine();
        $this->command?->info('=== Root sponsor member created ===');
        $this->command?->line("Sponsor ID (for registration): <fg=green>{$uniqueId}</>");
        $this->command?->line('Login User ID: '.$user->unique_id);
        $this->command?->line('Email: '.$user->email);
        $this->command?->line('Password: '.$plainPassword.' (change after first login)');
        $this->command?->newLine();
    }

    private function seedWallets(string $uniqueId): void
    {
        foreach (['wallet_primary', 'wallet_secondary', 'wallet_community'] as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            $exists = DB::table($table)->where('user_id', $uniqueId)->exists();
            if ($exists) {
                continue;
            }

            $row = ['user_id' => $uniqueId, 'balance' => 0];
            if (Schema::hasColumn($table, 'created_at')) {
                $row['created_at'] = now();
                $row['updated_at'] = now();
            }

            DB::table($table)->insert($row);
        }
    }
}
