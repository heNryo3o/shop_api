<?php

namespace App\Models;

class Setting extends PublicModel
{

    protected $rememberCacheTag = 'Setting';

    protected $fillable = [
        'banners',
        'ad_pic',
        'rate',
        'kefu',
        'deposits'
    ];

    protected $casts = [
        'banners'=>'json',
        'deposits' => 'json'
    ];

}
