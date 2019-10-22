<?php

namespace App\Models;

class Deposit extends PublicModel
{

    protected $fillable = [
        'status',
        'created_at',
        'updated_at',
        'user_id',
        'money',
        'pay_at',
        'out_trade_no',
        'payed_money',
        'deposit_money'
    ];

    protected $rememberCacheTag = 'Deposit';

}
