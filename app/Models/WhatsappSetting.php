<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappSetting extends Model
{
    protected $table = 'whatsapp_settings';

    protected $fillable = [
        'enabled',
        'mode',
        'graph_api_version',
        'phone_number_id',
        'access_token',
        'business_account_id',
        'webhook_verify_token',
        'otp_template_name',
        'otp_template_language',
        'otp_template_body_variables',
        'sandbox_default_otp',
        'otp_expiry_minutes',
        'otp_max_attempts',
        'otp_resend_cooldown_seconds',
        'require_otp_address_update',
        'welcome_template_name',
        'welcome_template_language',
        'welcome_template_body_variables',
        'welcome_enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'require_otp_address_update' => 'boolean',
        'welcome_enabled' => 'boolean',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'mode' => 'sandbox',
            'graph_api_version' => 'v25.0',
            'sandbox_default_otp' => '123456',
            'otp_template_body_variables' => 2,
            'otp_expiry_minutes' => 5,
            'otp_max_attempts' => 5,
            'otp_resend_cooldown_seconds' => 60,
        ]);
    }

    public function isLive(): bool
    {
        return $this->mode === 'live';
    }

    public function isSandbox(): bool
    {
        return $this->mode === 'sandbox';
    }
}
