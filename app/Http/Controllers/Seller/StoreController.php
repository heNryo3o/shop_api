<?php

namespace App\Http\Controllers\Seller;

use App\Http\Requests\Seller\ChangeStatusRequest;
use App\Http\Requests\Seller\DestroyRequest;
use App\Http\Requests\Seller\StoreRequest;
use App\Http\Resources\Seller\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
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

        Store::create($request->all());

        return $this->success();

    }

    public function edit(StoreRequest $request)
    {

        Store::find($request->id)->update($request->all());

        return $this->success();

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
