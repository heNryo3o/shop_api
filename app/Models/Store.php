<?php

namespace App\Models;

class Store extends PublicModel
{

    protected $rememberCacheTag = 'Store';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'username',
        'password',
        'status',
        'mobile',
        'licence',
        'id_card',
        'id_card_back',
        'category',
        'area',
        'address',
        'bank_card'
    ];

    protected $casts = [
        'area'=>'json',
        'category' => 'json'
    ];

    public function products()
    {
        return $this->hasMany(Store::class);
    }

}
