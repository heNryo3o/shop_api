<?php

namespace App\Models;

class PayLog extends PublicModel
{

    protected $rememberCacheTag = 'PayLog';

    protected $fillable = [
        'user_id',
        'money',
        'created_at',
        'updated_at',
        'type',
        'order_id'
    ];

}
