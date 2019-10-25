<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\PusherAddRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Weapp\BindMobileRequest;
use App\Http\Resources\Admin\BackenPusherResource;
use App\Http\Resources\Admin\UserLogResource;
use App\Http\Resources\Admin\UserResource;
use App\Models\BackenPusher;
use App\Models\Product;
use App\Models\PusherLog;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = User::filter($request->all())->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(UserResource::collection($list));

    }

    public function create(UserRequest $request)
    {

        User::create($request->all());

        return $this->success();

    }

    public function edit(UserRequest $request)
    {

        User::find($request->id)->update($request->all());

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        User::find($request->id)->update(['status'=>$request->status]);

        return $this->success();

    }

    public function destroy(DestroyRequest $request)
    {

        User::destroy($request->id);

        return $this->success();

    }

    public function logs(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = UserLog::filter($request->all())->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(UserLogResource::collection($list));

    }

    public function pushers(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $query = BackenPusher::where([]);

        $query = $request->mobile ? $query->where('mobile','like','%'.$request->mobile.'%') : $query;

        $list = $query->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(BackenPusherResource::collection($list));

    }

    public function pusherAdd(PusherAddRequest $request)
    {

        BackenPusher::create(['mobile'=>$request->mobile]);

        $user = User::where(['mobile'=>$request->mobile])->first();

        if($user && $user->is_pusher != 1){

            User::find($user->id)->update(['is_pusher'=>1]);

        }

        return $this->success();

    }

    public function info(Request $request)
    {

        $info = User::find($request->id)->toArray();

        $info['childs'] = User::where(['parent_user_id'=>$request->id])->orderBy('id','desc')->get();

        $info['childs'] = $info['childs'] ? $info['childs']->toArray() : [];

        $info['logs'] = PusherLog::where(['push_user_id'=>$request->id])->orderBy('id','desc')->get();

        if($info['logs']){

            $logs = $info['logs']->toArray();

            foreach ($logs as $k => &$v){

                $v['product_name'] = Product::find($v['product_id'])->name;

                $v['level_name'] = $v['level'] == 1 ? '直推' : '团推';

            }

            $info['logs'] = $logs;

        }

        return $this->success($info);

    }

}
