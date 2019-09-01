<?php

namespace App\Models;

class User extends PublicModel
{

    protected $rememberCacheTag = 'User';

    public function pushLogs()
    {
        return $this->hasMany(PushLog::class);
    }

}
