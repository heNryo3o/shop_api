<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\JwtAdmin
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JwtAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JwtAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JwtAdmin query()
 * @mixin \Eloquent
 */
class JwtAdmin extends Auth implements JWTSubject
{
    use Notifiable;

    protected $table = 'admins';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
