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

class StoreController extends Controller
{

    public function create(StoreRequest $request)
    {

        $data = $request->all();

        $data['is_online'] = $data['category'][0];

        $data['status'] = 1;

        $data['username'] = $data['mobile'];

        $data['password'] = bcrypt(substr($data['mobile'],-6));

        $data['city'] = isset($data['area']['1']) ? $data['area']['1'] : 0;

        $store = Store::create($data);

        $jim = new User(new JMessage(config('jim.key'), config('jim.secret')));

        $jim->register('kefu_'.$store->id, '123456');

        return $this->success();

    }

    public function edit(StoreRequest $request)
    {

        $store = Store::find($request->id);

        $data = $request->all();

        $data['status'] = $store->status == 2 ? 4 : $store->status;

        $store->update($data);

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

}
