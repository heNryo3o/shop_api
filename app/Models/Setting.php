<?php

namespace App\Models;

class Setting extends PublicModel
{

    protected $rememberCacheTag = 'Setting';

    protected $fillable = [
        'banners',
        'ad_pic'
    ];

    protected $casts = [
        'banners'=>'json'
    ];

}
