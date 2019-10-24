<?php

namespace App\Models;

class StoreMoneyLog extends PublicModel
{

    protected $rememberCacheTag = 'StoreMoneyLog';

    protected $fillable = [
        'store_id',
        'earn_money',
        'created_at',
        'updated_at',
        'order_id',
        'retail_1',
        'retail_2',
        'order_money',
        'cost_money'
    ];

}
