<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;
use App\Permissions\HasPermissionsTrait;

class Admin extends Authenticatable
{
    use Notifiable, HasPermissionsTrait;

    /**
     * Guard name (do NOT use $guard property)
     */
    protected $guard_name = 'admin';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_login_at',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'current_login_at'  => 'datetime',
        'last_login_at'     => 'datetime',
    ];

    /**
     * Automatically hash password on set
     */
    public function setPasswordAttribute($value)
    {
        if ($value && !str_starts_with($value, '$2') && !str_starts_with($value, '$argon')) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    /**
     * Admin password reset
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}
