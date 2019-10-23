<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\LoginRequest;
use App\Http\Requests\Weapp\BindMobileRequest;
use App\Http\Resources\Seller\StoreResource;
use App\Models\BackenPusher;
use App\Models\RecommenLog;
use App\Models\Store;
use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JMessage\JMessage;
use Tymon\JWTAuth\JWTAuth;

class UserController extends Controller
{

    public function token(Request $request)
    {

        $app = Factory::miniProgram(config('wechat.mini_program.default'));

        $auth = $app->auth->session($request->code);

        if(!isset($auth['openid'])){
            return $this->failed(json_encode($auth));
        }

        $open_id = $auth['openid'];

        $user = User::where(['open_id'=>$open_id])->first();

        if(!$user){

            $user = User::create(['open_id'=>$open_id]);

            $jim = new \JMessage\IM\User(new JMessage(config('jim.key'), config('jim.secret')));

            $jim->register('user_'.$user->id, '123456');

        }

        $token = auth('weapp')->tokenById($user->id);

        $user_info = $user->toArray();

        $is_new = isset($user_info['nickname']) && $user_info['nickname'] ? 0 : 1;

        return $this->success(['open_id'=>$open_id,'token'=>'Bearer '.$token,'userInfo'=>$user_info,'is_new'=>$is_new]);

    }

    public function jRegister(Request $request)
    {

        $user = User::find(auth('weapp')->id());

        $jim = new \JMessage\IM\User(new JMessage(config('jim.key'), config('jim.secret')));

        $jim->register('user_'.$user->id, '123456');

        return $this->success(['username'=>'user_'.$user->id]);

    }

    public function edit(Request $request)
    {

        $user_id = auth('weapp')->id();

        User::find($user_id)->update(['avatar'=>$request->avatar,'nickname'=>$request->nickname]);

        $jim = new \JMessage\IM\User(new JMessage(config('jim.key'), config('jim.secret')));

        $jim->update('user_'.$user_id, ['nickname' => $request->nickname, 'avatar' => $request->avatar]);

        return $this->success(['user_info'=>User::find($user_id)]);

    }

    public function bindMobile(BindMobileRequest $request)
    {

        $user = User::find(auth('weapp')->id());

        $pusher = BackenPusher::where(['mobile'=>$request->mobile])->first();

        if($pusher){
            $user->update(
                [
                    'mobile' => $request->mobile,
                    'is_pusher' => 1
                ]
            );
        }else{
            $user->update([
                'mobile' => $request->mobile
            ]);
        }

        return $this->success();

    }

    public function info()
    {

        $user = User::find(auth('weapp')->id());

        return $this->success($user);

    }

    public function bindPush(Request $request)
    {

        RecommenLog::create([
            'product_id' => $request->product_id,
            'push_user_id' => $request->push_user_id,
            'get_user_id' => auth('weapp')->id()
        ]);

        return $this->success();

    }

    public function bindParent(Request $request)
    {

        $user_id = auth('weapp')->id();

        $push_user_id = $request->push_user_id;

        $user = User::find($user_id);

        if($user->parent_id || $user->is_pusher == 1){
            return $this->success();
        }

        $user->update([
            'parent_user_id' => $push_user_id,
            'is_pusher' => 1
        ]);

        return $this->success();

    }

}
