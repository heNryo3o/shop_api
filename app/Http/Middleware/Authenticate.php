<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {

        $uri = $request->route()->uri;

        $white_list = [
            'weapp/user/login'
        ];

        if(in_array($uri,$white_list)){
            return;
        }

        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);
                return;
            }
        }

        throw new UnauthorizedHttpException('请登录');

    }

}
