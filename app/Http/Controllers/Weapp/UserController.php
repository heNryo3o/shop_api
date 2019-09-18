<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\LoginRequest;
use App\Http\Resources\Seller\StoreResource;
use App\Models\Store;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

class UserController extends Controller
{

    public function login(LoginRequest $request, JWTAuth $jwt_auth)
    {

        $app = Factory::miniProgram(config('wechat.mini_program.default'));

        $data = $app->auth->session($request->code);

        var_dump($data);

//        $username = $request->input('username');
//
//        $password = $request->input('password');
//
//        $admin = Store::where(['username' => $username, 'status' => 1])->first();
//
//        if (empty($admin)) {
//            return $this->failed('您的管理员账号已被停用');
//        }
//
//        $token = Auth::guard('seller')->attempt(['username'=>$username,'password'=>$password]);
//
//        if(!$token){
//            return $this->failed('用户名或密码错误，请重试！');
//        }
//
//        return $this->success(['token' => 'Bearer '.$token]);

    }

    public function logout()
    {

        auth('seller')->logout();

        return $this->success();

    }

    public function info()
    {

        $id = auth('seller')->id();

        $user = Store::where('id',$id)->first();

        return $this->success(new StoreResource($user));

    }

}
