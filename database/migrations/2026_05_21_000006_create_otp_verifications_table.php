<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('otp_verifications')) {
            Schema::create('otp_verifications', function (Blueprint $table) {
                $table->id();
                $table->string('purpose', 40);
                $table->string('phone_e164', 30);
                $table->unsignedBigInteger('country_id')->nullable();
                $table->string('user_unique_id', 50)->nullable();
                $table->string('otp_hash');
                $table->unsignedTinyInteger('attempts')->default(0);
                $table->timestamp('expires_at');
                $table->timestamp('verified_at')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->string('verification_token', 64)->nullable()->unique();
                $table->timestamps();
                $table->index(['phone_e164', 'purpose', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};
