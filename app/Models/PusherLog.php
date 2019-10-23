<?php

namespace App\Models;

class PusherLog extends PublicModel
{

    protected $rememberCacheTag = 'PusherLog';

    protected $fillable = [
        'created_at',
        'updated_at',
        'product_id',
        'push_user_id',
        'buy_user_id',
        'level',
        'parent_user_id',
        'retail'
    ];

}
