<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $table = 'otp_verifications';

    protected $fillable = [
        'purpose',
        'phone_e164',
        'country_id',
        'user_unique_id',
        'otp_hash',
        'attempts',
        'expires_at',
        'verified_at',
        'consumed_at',
        'ip_address',
        'verification_token',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'consumed_at' => 'datetime',
    ];

    public const PURPOSE_REGISTRATION = 'registration';

    public const PURPOSE_ADDRESS_UPDATE = 'address_update';
}
