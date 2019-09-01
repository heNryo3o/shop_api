<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\ServiceRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Product::filter($request->all())->with(['user:users.id,users.mobile','store:stores.id,stores.name'])->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(ProductResource::collection($list));

    }

    public function create(ServiceRequest $request)
    {

        Product::create($request->all());

        return $this->success();

    }

    public function edit(ServiceRequest $request)
    {

        Product::find($request->id)->update($request->all());

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        Product::find($request->id)->update(['status'=>$request->status]);

        return $this->success();

    }

    public function destroy(DestroyRequest $request)
    {

        Product::destroy($request->id);

        return $this->success();

    }

}
