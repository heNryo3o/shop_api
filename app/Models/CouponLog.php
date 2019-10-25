<?php

namespace App\Models;

class CouponLog extends PublicModel
{

    protected $fillable = [
        'type',
        'created_at',
        'updated_at',
        'money'
    ];

    protected $rememberCacheTag = 'CouponLog';

}
