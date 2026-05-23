<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class PackagePurchaseEngine
{
    public static function enabled(): bool
    {
        if (! Schema::hasTable('settings') || ! Schema::hasColumn('settings', 'package_purchase_engine_enabled')) {
            return true;
        }

        return (bool) Cache::remember('package_purchase_engine_enabled', 30, function () {
            $setting = Setting::query()->first();

            if (! $setting) {
                return true;
            }

            return (bool) ($setting->package_purchase_engine_enabled ?? true);
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('package_purchase_engine_enabled');
    }
}
