<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class JwtSeller extends Auth implements JWTSubject
{
    use Notifiable;

    protected $table = 'stores';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
