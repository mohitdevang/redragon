<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('settings') && ! Schema::hasColumn('settings', 'income_engine_enabled')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->boolean('income_engine_enabled')->default(false)->after('date_withdrawl');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('settings', 'income_engine_enabled')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('income_engine_enabled');
            });
        }
    }
};
