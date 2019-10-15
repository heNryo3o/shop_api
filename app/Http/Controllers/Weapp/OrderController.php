<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function cartCreate(Request $request)
    {

        $user_id = auth('weapp')->id();

        $order_data = [
            'no' => 'NO'.date('YmdHis',time()).random_int(100000,999999),
            'user_id' => $user_id,
            'total_amount' => $request->total_amount,
        ];

        $order = Order::create($order_data);

        $list = CartItem::whereIn('id',$request->cart_item_ids)->get()->toArray();

        foreach($list as $k => $v){

            $item_data = [
                'order_id' => $order->id,
                'product_id' => $v['product_id'],
                'product_sku_id' => $v['product_sku_id'],
                'store_id' => $v['store_id'],
                'amount' => $v['amount'],
                'price' => ProductSku::find($v['product_sku_id'])->price,
                'user_id' => $user_id
            ];

            OrderItem::create($item_data);

            CartItem::find($v['id'])->delete();

        }

        return $this->success(['order_id'=>$order->id]);

    }

    public function info(Request $request)
    {

        $order = Order::find($request->id)->toArray();

        $order['items'] = OrderItem::where(['order_id'=>$request->id])->get()->toArray();

        foreach ($order['items'] as $k => &$v){

            $product = Product::find($v['product_id']);

            $v['product_name'] = $product->name;

            $v['product_thumb'] = $product->thumb;

        }

        return $this->success($order);

    }

    public function submit(Request $request)
    {



    }

}
