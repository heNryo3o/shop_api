<?php

namespace App\Models;

class Banner extends PublicModel
{

    protected $fillable = [
        'attach',
        'created_at',
        'updated_at',
        'status'
    ];

    protected $rememberCacheTag = 'Banner';

}
