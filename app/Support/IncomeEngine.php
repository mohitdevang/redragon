<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class IncomeEngine
{
    public static function enabled(): bool
    {
        if (! Schema::hasTable('settings') || ! Schema::hasColumn('settings', 'income_engine_enabled')) {
            return false;
        }

        return (bool) Cache::remember('income_engine_enabled', 30, function () {
            $setting = Setting::query()->first();

            return $setting && (bool) $setting->income_engine_enabled;
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('income_engine_enabled');
    }
}
