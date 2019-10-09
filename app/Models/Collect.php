<?php

namespace App\Models;

class Collect extends PublicModel
{

    protected $fillable = [
        'type',
        'user_id',
        'created_at',
        'updated_at',
        'item_id',
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
