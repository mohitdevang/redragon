<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('otp_verifications') && ! Schema::hasColumn('otp_verifications', 'consumed_at')) {
            Schema::table('otp_verifications', function (Blueprint $table) {
                $table->timestamp('consumed_at')->nullable()->after('verified_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('otp_verifications', 'consumed_at')) {
            Schema::table('otp_verifications', function (Blueprint $table) {
                $table->dropColumn('consumed_at');
            });
        }
    }
};
