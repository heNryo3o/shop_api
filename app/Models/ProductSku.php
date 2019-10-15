<?php

namespace App\Models;

class ProductSku extends PublicModel
{

    protected $fillable = ['title', 'description', 'price', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
