<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Seller\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Order::filter($request->all())->where('store_id',auth('seller')->id())->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(OrderResource::collection($list));

    }

    public function sendProduct(Request $request)
    {

        $order = Order::find($request->id);

        if($order->status != 2){
            return $this->failed('当前订单状态不可以进行确认发货操作');
        }

        $order->update([
            'send_at' => now(),
            'status' => 3
        ]);

        return $this->success();

    }

}
