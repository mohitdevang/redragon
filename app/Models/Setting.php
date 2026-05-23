<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['title','tagline','emails','cc_emails','bcc_emails','logo','favicon','loginbg','site_key','secret_key','google_analytics','noti_dashboard','noti_kyc','noti_pin','total_team','total_team_active','scanner','date_withdrawl','income_engine_enabled','package_purchase_engine_enabled','login_modal_enabled','login_modal_image'];

    protected $casts = [
        'income_engine_enabled' => 'boolean',
        'package_purchase_engine_enabled' => 'boolean',
        'login_modal_enabled' => 'boolean',
    ];
    public $timestamps = false;
}
