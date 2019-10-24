<?php

namespace App\Models;

class PusherCashLog extends PublicModel
{

    protected $rememberCacheTag = 'PusherCashLog';

    protected $fillable = [
        'user_id',
        'money',
        'created_at',
        'updated_at',
        'status'
    ];

}
