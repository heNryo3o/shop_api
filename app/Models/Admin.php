<?php

namespace App\Models;

class Admin extends PublicModel
{

    protected $fillable = [
        'true_name',
        'username',
        'mobile',
        'avatar',
        'department',
        'duty',
        'password',
        'password_salt',
        'status',
        'created_at',
        'updated_at',
        'current_token'
    ];

    protected $rememberCacheTag = 'Admin';

    public function roles()
    {

        return $this->belongsToMany(Role::class);

    }

    public function permissions()
    {

        return $this->belongsToMany(Permission::class);

    }

}
