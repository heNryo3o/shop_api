<?php

namespace App\Models;

class ProductSku extends PublicModel
{

    protected $fillable = ['title', 'description', 'price', 'stock','product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
