<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('whatsapp_logs')) {
            Schema::create('whatsapp_logs', function (Blueprint $table) {
                $table->id();
                $table->string('message_type', 50);
                $table->string('user_id', 50)->nullable();
                $table->string('mobile_number', 30)->nullable();
                $table->string('country_code', 8)->nullable();
                $table->string('template_name')->nullable();
                $table->json('request_payload')->nullable();
                $table->json('response_payload')->nullable();
                $table->string('status', 30)->default('pending');
                $table->text('error_message')->nullable();
                $table->string('provider_message_id')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamps();
                $table->index(['message_type', 'created_at']);
                $table->index('mobile_number');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_logs');
    }
};
