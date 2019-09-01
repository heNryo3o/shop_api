<?php

namespace App\Models;

class Product extends PublicModel
{

    protected $rememberCacheTag = 'Product';

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
