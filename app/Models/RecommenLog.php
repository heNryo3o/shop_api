<?php

namespace App\Models;

class RecommenLog extends PublicModel
{

    protected $rememberCacheTag = 'RecommenLog';

    protected $fillable = [
        'created_at',
        'updated_at',
        'product_id',
        'push_user_id',
        'get_user_id'
    ];

}
