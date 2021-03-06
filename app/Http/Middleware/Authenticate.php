<?php

namespace App\Http\Middleware;

use App\Models\JwtWeapp;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards)
    {

        $uri = $request->route()->uri;

        $white_list = [
            'weapp/user/token',
            'weapp/category/index',
            'weapp/product/index',
            'weapp/system/banners',
            'weapp/product/dapai',
            'seller/login/login',
            'admin/login/login',
            'seller/system/upload',
            'admin/system/upload',
            'seller/category/options',
            'seller/store/create',
            'weapp/system/chat-log',
            'weapp/system/notify',
            'weapp/system/upload',
            'weapp/order/check-order',
            'weapp/order/confirm-check',
        ];

        if(in_array($uri,$white_list)){
            return;
        }

        if(substr($uri,0,5 ) == 'weapp') {

            $user = User::where(['open_id' => $request->open_id])->first();

            if ($user) {

                auth('weapp')->setUser(JwtWeapp::find($user->id));

                return;

            }

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
