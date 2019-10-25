<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\LoginRequest;
use App\Http\Resources\Seller\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{

    public function login(LoginRequest $request, JWTAuth $jwt_auth)
    {

        $username = $request->input('username');

        $password = $request->input('password');

        $admin = Store::where(['username' => $username])->first();

        if (empty($admin)) {
            return $this->failed('用户名或密码错误');
        }

        if($admin->status == 1){
            return $this->failed('您的店铺正在审核中，请耐心等待');
        }

        if($admin->status == 3){
            return $this->failed('您的店铺信息未通过审核');
        }

        if($admin->status == 5){
            return $this->failed('您的店铺已被管理员停用');
        }

        $token = Auth::guard('seller')->attempt(['username'=>$username,'password'=>$password]);

        if(!$token){
            return $this->failed('用户名或密码错误，请重试！');
        }

        return $this->success(['token' => 'Bearer '.$token]);

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

    public function changePassword(Request $request)
    {

        Store::find(auth('seller')->id())->update(['password'=>bcrypt($request->password)]);

        return $this->success();

    }

}
