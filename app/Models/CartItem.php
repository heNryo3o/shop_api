<?php

namespace App\Models;

class CartItem extends PublicModel
{

    protected $fillable = [
        'user_id',
        'product_sku_id',
        'created_at',
        'updated_at',
        'amount',
        'product_id',
        'store_id'
    ];

    protected $rememberCacheTag = 'CartItem';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }

}
