<?php

namespace App\Models;

class OrderItem extends PublicModel
{

    protected $fillable = [
        'order_id',
        'product_id',
        'product_sku_id',
        'store_id',
        'amount',
        'price',
        'rating',
        'review',
        'review_at',
        'user_id',
        'status',
        'title',
        'product_name'
    ];

}
