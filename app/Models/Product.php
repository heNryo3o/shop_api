<?php

namespace App\Models;

class Product extends PublicModel
{

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'price',
        'retail_1',
        'retail_2',
        'thumb',
        'content',
        'category_id',
        'sold',
        'browse',
        'store_id',
        'status',
        'attaches',
        'collect',
        'remain',
        'sub_category_id',
        'evalue',
        'is_dapai',
        'category',
        'attention',
        'is_online',
        'sold_user',
        'evalues'
    ];

    protected $casts = [
        'attaches' => 'json',
        'category' => 'json',
        'evalues' => 'json'
    ];

    protected $rememberCacheTag = 'Product';

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

}
