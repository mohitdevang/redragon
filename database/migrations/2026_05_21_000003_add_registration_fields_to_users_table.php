<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'registration_serial')) {
                $table->unsignedBigInteger('registration_serial')->nullable()->unique()->after('id');
            }
            if (! Schema::hasColumn('users', 'country_id')) {
                $table->unsignedBigInteger('country_id')->nullable()->after('country');
            }
            if (! Schema::hasColumn('users', 'dial_code')) {
                $table->string('dial_code', 8)->nullable()->after('phone');
            }
        });

        if (Schema::hasColumn('users', 'registration_serial')) {
            $users = DB::table('users')->whereNull('registration_serial')->orderBy('id')->get(['id']);
            $serial = (int) DB::table('users')->max('registration_serial');
            foreach ($users as $user) {
                $serial++;
                DB::table('users')->where('id', $user->id)->update(['registration_serial' => $serial]);
            }
        }

        if (Schema::hasColumn('users', 'phone')) {
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->unique('phone');
                });
            } catch (\Throwable $e) {
                // Existing duplicates must be resolved manually before unique index applies.
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone')) {
                try {
                    $table->dropUnique(['phone']);
                } catch (\Throwable $e) {
                }
            }
            if (Schema::hasColumn('users', 'dial_code')) {
                $table->dropColumn('dial_code');
            }
            if (Schema::hasColumn('users', 'country_id')) {
                $table->dropColumn('country_id');
            }
            if (Schema::hasColumn('users', 'registration_serial')) {
                $table->dropColumn('registration_serial');
            }
        });
    }
};
