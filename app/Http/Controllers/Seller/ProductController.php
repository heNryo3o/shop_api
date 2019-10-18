<?php

namespace App\Http\Controllers\Seller;

use App\Http\Requests\Seller\ChangeStatusRequest;
use App\Http\Requests\Seller\DestroyRequest;
use App\Http\Requests\Seller\StoreRequest;
use App\Http\Resources\Admin\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JMessage\IM\User;
use JMessage\JMessage;

class ProductController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Store::filter($request->all())->with('user:users.id,users.mobile')->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(StoreResource::collection($list));

    }

    public function create(StoreRequest $request)
    {

        $data = $request->all();

        $data['is_online'] = $data['category'][0];

        $data['status'] = 1;

        $data['username'] = $data['mobile'];

        $data['password'] = bcrypt(substr($data['mobile'],-6));

        $store = Store::create($data);

        $jim = new User(new JMessage(config('jim.key'), config('jim.secret')));

        $jim->register('kefu_'.$store->id, '123456');

        return $this->success();

    }

    public function edit(StoreRequest $request)
    {

        Store::find($request->id)->update($request->all());

        $jim = new User(new JMessage(config('jim.key'), config('jim.secret')));

        $jim->update('kefu_'.$request->id, ['avatar'=>$request->logo,'nickname'=>$request->name]);

        return $this->success();

    }

    public function info()
    {

        $store_id = auth('seller')->id();

        $store = Store::find($store_id);

        return $this->success(new StoreResource($store));

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        Store::find($request->id)->update(['status'=>$request->status]);

        return $this->success();

    }

    public function destroy(DestroyRequest $request)
    {

        Store::destroy($request->id);

        return $this->success();

    }

}
