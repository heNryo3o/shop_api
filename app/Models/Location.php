<?php

namespace App\Models;

class Location extends PublicModel
{

    protected $fillable = [
        'created_at',
        'updated_at',
        'user_id',
        'address',
        'address_detail',
        'is_default',
        'linkman',
        'mobile'
    ];

    protected $rememberCacheTag = 'Location';

}
