<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('whatsapp_settings')) {
            Schema::create('whatsapp_settings', function (Blueprint $table) {
                $table->id();
                $table->boolean('enabled')->default(false);
                $table->string('mode', 20)->default('sandbox');
                $table->string('graph_api_version', 20)->default('v25.0');
                $table->string('phone_number_id')->nullable();
                $table->text('access_token')->nullable();
                $table->string('business_account_id')->nullable();
                $table->string('webhook_verify_token')->nullable();
                $table->string('otp_template_name')->nullable();
                $table->string('otp_template_language', 20)->default('en_US');
                $table->unsignedTinyInteger('otp_template_body_variables')->default(2);
                $table->string('sandbox_default_otp', 10)->default('123456');
                $table->unsignedSmallInteger('otp_expiry_minutes')->default(5);
                $table->unsignedTinyInteger('otp_max_attempts')->default(5);
                $table->unsignedSmallInteger('otp_resend_cooldown_seconds')->default(60);
                $table->boolean('require_otp_address_update')->default(true);
                $table->string('welcome_template_name')->nullable();
                $table->string('welcome_template_language', 20)->default('en');
                $table->unsignedTinyInteger('welcome_template_body_variables')->default(7);
                $table->boolean('welcome_enabled')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_settings');
    }
};
