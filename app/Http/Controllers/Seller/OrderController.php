<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Seller\OrderResource;
use App\Models\Order;
use App\Models\User;
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

    public function agreeRefund(Request $request)
    {

        $order = Order::find($request->id);

        if($order->status != 6){
            return $this->failed('当前订单状态不可以进行同意退款操作');
        }

        // 把订单金额退到用户余额

        $user = User::find($order->user_id);

        $user->update([
            'remain_money' => $user->remain_money + $order->total_amount
        ]);

        $order->update([
            'refund_end_at' => now(),
            'status' => 7
        ]);

        return $this->success();

    }

}
