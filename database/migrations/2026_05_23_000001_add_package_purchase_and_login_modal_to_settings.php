<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        Schema::table('settings', function (Blueprint $table) {
            if (! Schema::hasColumn('settings', 'package_purchase_engine_enabled')) {
                $table->boolean('package_purchase_engine_enabled')->default(true)->after('income_engine_enabled');
            }
            if (! Schema::hasColumn('settings', 'login_modal_enabled')) {
                $table->boolean('login_modal_enabled')->default(false)->after('package_purchase_engine_enabled');
            }
            if (! Schema::hasColumn('settings', 'login_modal_image')) {
                $table->string('login_modal_image')->nullable()->after('login_modal_enabled');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        Schema::table('settings', function (Blueprint $table) {
            foreach (['package_purchase_engine_enabled', 'login_modal_enabled', 'login_modal_image'] as $col) {
                if (Schema::hasColumn('settings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
