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
        'bank_card',
        'collect',
        'user_id',
        'logo',
        'thumb',
        'evalue',
        'is_online'
    ];

    protected $casts = [
        'area'=>'json',
        'category' => 'json'
    ];

    protected $appends = [
        'product_num'
    ];

    public function getProductNumAttribute()
    {
        return Product::where(['store_id'=>$this->id,'status'=>1])->count();
    }

    public function products()
    {
        return $this->hasMany(Store::class);
    }

}
