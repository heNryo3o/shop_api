<?php

namespace App\Models;

class BackenPusher extends PublicModel
{

    protected $fillable = [
        'mobile',
        'created_at',
        'updated_at'
    ];

    protected $rememberCacheTag = 'BackenPusher';

}
