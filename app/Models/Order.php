<?php

namespace App\Models;

class Order extends PublicModel
{

    protected $fillable = [
        'no',
        'user_id',
        'address',
        'total_amount',
        'remark',
        'paid_at',
        'payment_method',
        'payment_no',
        'refund_status',
        'refund_no',
        'closed',
        'reviewed',
        'ship_status'
    ];

}
