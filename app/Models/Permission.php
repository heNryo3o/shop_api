<?php

namespace App\Models;

class Permission extends PublicModel
{

    protected $fillable = [
        'parent_id',
        'name',
        'key',
        'created_at',
        'updated_at',
        'status'
    ];

    protected $rememberCacheTag = 'Permission';

    public function admins()
    {

        return $this->belongsToMany(Admin::class);

    }

    public function roles()
    {

        return $this->belongsToMany(Role::class);

    }

}
