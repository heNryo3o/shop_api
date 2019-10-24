<?php

namespace App\Models;

class PusherBindLog extends PublicModel
{

    protected $fillable = [
        'created_at',
        'updated_at',
        'parent_user_id',
        'child_user_id'
    ];

    protected $rememberCacheTag = 'PusherBindLog';

}
