<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappLog extends Model
{
    protected $table = 'whatsapp_logs';

    protected $fillable = [
        'message_type',
        'user_id',
        'mobile_number',
        'country_code',
        'template_name',
        'request_payload',
        'response_payload',
        'status',
        'error_message',
        'provider_message_id',
        'sent_at',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
        'sent_at' => 'datetime',
    ];
}
