<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UserResetPasswordNotification;
use App\Permissions\HasPermissionsTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasPermissionsTrait;

    protected $fillable = [
        'unique_id',
        'registration_serial',
        'seq_pin',
        'name',
        'email',
        'phone',
        'dial_code',
        'country_id',
        'country',
        'password',
        'current_login_at',
        'last_login_at',
        'last_login_ip',
        'secpwd',
        'adhar_no',
        'upgrade_active_date',
        'invest_amount',
        'income_limit',
        'address',
        'city',
        'state',
        'pincode',
        'trc_address',
        'moninee',
        'bank_name',
        'ac_holder_name',
        'ac_number',
        'ifsc',
        'gpay',
        'phhonepay',
        'Paytm',
        'kys_status',
        'package_id',
        'status',
        'active_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(
            new UserResetPasswordNotification($token, $this->name)
        );
    }
}
