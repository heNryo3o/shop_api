<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Http\Resources\Weapp\OrderResource;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {

        $query = Order::where('user_id',auth('weapp')->id());

        $query = $request->status > 0 ? $query->where('status',$request->status) : $query;

        $list = $query->orderBy('id','desc')->paginate(10000);

        return $this->success(OrderResource::collection($list));

    }

    public function cartCreate(Request $request)
    {

        $user_id = auth('weapp')->id();

        $order_data = [
            'no' => 'NO'.date('YmdHis',time()).random_int(100000,999999),
            'user_id' => $user_id,
            'total_amount' => $request->total_amount,
            'status' => 1
        ];

        $list = CartItem::whereIn('id',$request->cart_item_ids)->get()->toArray();

        foreach($list as $k => $v){

            $sku = ProductSku::find($v['product_sku_id']);

            if($v['amount'] > $sku->stock){
                return $this->failed('您选购的'.Product::find($v['product_id'])->name.'商品'.$sku->title.'型号库存仅剩余'.$sku->stock.'件，无法下单');
            }

            $order_data['store_id'] = $v['store_id'];

        }

        $order = Order::create($order_data);

        foreach($list as $k => $v){

            $sku = ProductSku::find($v['product_sku_id']);

            $sku->update(['stock'=>($sku->stock-$v['amount'])]);

            $item_data = [
                'order_id' => $order->id,
                'product_id' => $v['product_id'],
                'product_name' => Product::find($v['product_id'])->name,
                'title' => $sku->title,
                'product_sku_id' => $v['product_sku_id'],
                'store_id' => $v['store_id'],
                'amount' => $v['amount'],
                'price' => $sku->price,
                'user_id' => $user_id
            ];

            OrderItem::create($item_data);

//            CartItem::find($v['id'])->delete();

        }

        return $this->success(['order_id'=>$order->id]);

    }

    public function info(Request $request)
    {

        $order = Order::find($request->id);

//        $order['items'] = OrderItem::where(['order_id'=>$request->id])->get()->toArray();

//        foreach ($order['items'] as $k => &$v){
//
//            $product = Product::find($v['product_id']);
//
//            $v['product_name'] = $product->name;
//
//            $v['product_thumb'] = $product->thumb;
//
//        }

        return $this->success(new OrderResource($order));

    }

    public function submit(Request $request)
    {



    }

}
