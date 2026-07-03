<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'user_id',
        'device_id',
        'platform',
        'fcm_token',
        'device_name',
        'is_active',
        'last_seen_at'
    ];
}
