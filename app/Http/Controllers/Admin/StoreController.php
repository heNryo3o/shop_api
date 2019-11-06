<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Resources\Admin\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JMessage\IM\Report;

class StoreController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Store::filter($request->all())->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(StoreResource::collection($list));

    }

    public function info(Request $request)
    {

        $info = Store::find($request->id);

        return $this->success(new StoreResource($info));

    }

    public function create(StoreRequest $request)
    {

        Store::create($request->all());

        return $this->success();

    }

    public function edit(StoreRequest $request)
    {

        $data = $request->all();

        $data['category_id'] = isset($data['category'][1]) ? $data['category'][1] : 0;

        $data['sub_category_id'] = isset($data['category'][2]) ? $data['category'][2] : 0;

        Store::find($request->id)->update($data);

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
