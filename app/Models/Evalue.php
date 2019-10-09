<?php

namespace App\Models;

class Evalue extends PublicModel
{

    protected $fillable = [
        'rate',
        'user_id',
        'created_at',
        'updated_at',
        'product_id',
        'content',
        'attaches'
    ];

    protected $casts = [
        'attaches' => 'json'
    ];

    protected $rememberCacheTag = 'Product';

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
