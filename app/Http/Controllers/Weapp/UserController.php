<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\LoginRequest;
use App\Http\Requests\Weapp\BindMobileRequest;
use App\Http\Resources\Seller\StoreResource;
use App\Models\Area;
use App\Models\BackenPusher;
use App\Models\PusherBindLog;
use App\Models\PusherCashLog;
use App\Models\PusherLog;
use App\Models\RecommenLog;
use App\Models\RemainLog;
use App\Models\Setting;
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
            'is_pusher' => 1,
            'pusher_at' => now()
        ]);

        PusherBindLog::create(['parent_user_id'=>$push_user_id,'child_user_id'=>$user_id]);

        return $this->success();

    }

    public function remainLog(Request $request)
    {

        $list = RemainLog::where(['user_id'=>auth('weapp')->id()])->orderBy('id','desc')->get();

        return $this->success(['list'=>$list]);

    }

    public function pushLog(Request $request)
    {

        $list = PusherLog::where(['push_user_id'=>auth('weapp')->id()])->orderBy('id','desc')->get();

        $total_earn = 0;

        if($list){

            foreach ($list->toArray() as $k => $v){

                $total_earn += $v['retail'];

            }

        }

        return $this->success(['list'=>$list,'total_earn'=>$total_earn,'invite_src'=>User::find(auth('weapp')->id())->invite_src]);

    }

    public function childList(Request $request)
    {

        $list = User::where(['parent_user_id'=>auth('weapp')->id()])->orderBy('id','desc')->get();

        return $this->success(['list'=>$list]);

    }

    public function cashInfo()
    {

        $setting = Setting::find(1);

        $user = User::find(auth('weapp')->id());

        return $this->success(
            [
                'money' => $user->money,
                'money_block' => $user->money_block,
                'kefu' => $setting->kefu,
            ]
        );

    }

    public function cashOut(Request $request)
    {

        $money = $request->money;

        $user = User::find(auth('weapp')->id());

        if($money < 50){
            return $this->failed('提现金额不能低于50元');
        }

        if($money > ($user->money - $user->money_block)){
            return $this->failed('提现金额不能大于可提现总额');
        }

        $user->update(['money_block'=>$user->money_block+$money]);

        PusherCashLog::create(
            [
                'user_id' => auth('weapp')->id(),
                'money' => $money,
                'status' => 1
            ]
        );

        return $this->success();

    }

    public function cashLog(Request $request)
    {

        $list = PusherCashLog::where(['user_id'=>auth('weapp')->id()])->orderBy('id','desc')->get();

        return $this->success(['list'=>$list]);

    }

    public function bindArea(Request $request)
    {

        $area = Area::find($request->area_id);

        $city_code = $area ? $area->parent_id : 0;

        if($city_code > 0){

            User::find(auth('weapp')->id())->update(['city'=>$city_code]);

        }

        return $this->success();

    }

}
