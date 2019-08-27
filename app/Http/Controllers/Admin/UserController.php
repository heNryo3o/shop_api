<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\Admin\UserLogResource;
use App\Http\Resources\Admin\UserResource;
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

}
