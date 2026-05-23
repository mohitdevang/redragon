<?php

namespace Database\Seeders;

use App\Models\WhatsappSetting;
use Illuminate\Database\Seeder;

class WhatsappSettingsSeeder extends Seeder
{
    public function run(): void
    {
        WhatsappSetting::query()->firstOrCreate([], [
            'enabled' => false,
            'mode' => 'sandbox',
            'graph_api_version' => 'v25.0',
            'sandbox_default_otp' => '123456',
            'otp_template_language' => 'en_US',
            'otp_template_body_variables' => 2,
            'otp_expiry_minutes' => 5,
            'otp_max_attempts' => 5,
            'otp_resend_cooldown_seconds' => 120,
            'require_otp_address_update' => true,
            'welcome_enabled' => false,
            'welcome_template_language' => 'en',
            'welcome_template_body_variables' => 10,
        ]);
    }
}
