<?php

namespace App\Models;

class Coupon extends PublicModel
{

    protected $fillable = [
        'type',
        'user_id',
        'created_at',
        'updated_at',
        'status',
        'used_at',
        'money'
    ];

    protected $rememberCacheTag = 'Coupon';

}
