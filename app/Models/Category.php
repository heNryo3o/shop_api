<?php

namespace App\Models;

class Category extends PublicModel
{

    protected $fillable = [
        'name',
        'parent_id',
        'thumb',
        'status',
        'updated_at',
        'created_at',
        'level',
        'admin_id'
    ];

    protected $rememberCacheTag = 'Category';

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}
