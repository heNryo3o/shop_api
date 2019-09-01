<?php

namespace App\Models;

class Store extends PublicModel
{

    protected $rememberCacheTag = 'Store';

    public function products()
    {
        return $this->hasMany(Store::class);
    }

}
