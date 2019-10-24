<?php

namespace App\Models;

class RemainLog extends PublicModel
{

    protected $rememberCacheTag = 'RemainLog';

    protected $fillable = [
        'user_id',
        'money',
        'created_at',
        'updated_at',
        'type',
        'order_id'
    ];

}
