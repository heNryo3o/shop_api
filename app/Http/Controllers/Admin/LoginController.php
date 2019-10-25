<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\EditLoginRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{

    public function login(LoginRequest $request, JWTAuth $jwt_auth)
    {

        $username = $request->input('username');

        $password = $request->input('password');

        $admin = Admin::where(['username' => $username, 'status' => 1])->first();

        if (empty($admin)) {
            return $this->failed('您的管理员账号已被停用');
        }

        $token = Auth::guard('admin')->attempt(['username'=>$username,'password'=>$password]);

        if(!$token){
            return $this->failed('用户名或密码错误，请重试！');
        }

        return $this->success(['token' => 'Bearer '.$token]);

    }

    public function logout()
    {

        auth('admin')->logout();

        return $this->success();

    }

    public function info()
    {

        $id = auth('admin')->id();

        $user = Admin::where('id',$id)->with(['roles:roles.id,name','permissions:permissions.id'])->first();

        return $this->success(new AdminResource($user));

    }

    public function edit(EditLoginRequest $request)
    {

        Admin::find(auth('admin')->id())->update($request->all());

        return $this->success();

    }

    public function changePassword(ChangePasswordRequest $request)
    {

        Admin::find(auth('admin')->id())->update(['password'=>bcrypt($request->password)]);

        return $this->success();

    }

}
