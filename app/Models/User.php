<?php

namespace App\Models;

class User extends PublicModel
{

    protected $fillable = [
        'nickname',
        'open_id',
        'status',
        'created_at',
        'updated_at',
        'avatar'
    ];

    protected $rememberCacheTag = 'User';

    public function pushLogs()
    {
        return $this->hasMany(PushLog::class);
    }

}
