<?php

namespace App\Models;

class Admin extends PublicModel
{

    protected $fillable = [
        'true_name',
        'username',
        'avatar',
        'password',
        'password_salt',
        'status',
        'created_at',
        'updated_at'
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
