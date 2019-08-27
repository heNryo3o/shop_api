<?php

namespace App\Models;

class Role extends PublicModel
{

    protected $fillable = [
        'name',
        'describe',
        'created_at',
        'updated_at',
        'status'
    ];

    protected $rememberCacheTag = 'Role';

    protected $casts = [
        'permissions'=>'json'
    ];

    public function admins()
    {

        return $this->belongsToMany(Admin::class);

    }

    public function permissions()
    {

        return $this->belongsToMany(Permission::class);

    }

}
