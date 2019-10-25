<?php

namespace App\Models;

class StoreCashLog extends PublicModel
{

    protected $rememberCacheTag = 'StoreCashLog';

    protected $fillable = [
        'store_id',
        'money',
        'created_at',
        'updated_at',
        'status'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
