<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SystemSettingsSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $setting = Setting::query()->first();
        if ($setting && Schema::hasColumn('settings', 'income_engine_enabled')) {
            $setting->income_engine_enabled = false;
            $setting->save();
        }
    }
}
