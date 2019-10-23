<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Http\Resources\Weapp\OrderResource;
use App\Models\CartItem;
use App\Models\Deposit;
use App\Models\DepositSetting;
use App\Models\Evalue;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSku;
use App\Models\PusherLog;
use App\Models\RecommenLog;
use App\Models\RecommenRelation;
use App\Models\Setting;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Yansongda\LaravelPay\Facades\Pay;

class OrderController extends Controller
{

    public function index(Request $request)
    {

        $query = Order::where('user_id', auth('weapp')->id());

        $status = $request->status;

        if ($status == 1) {

            // 待付款
            $query = $query->where('status', 1);

        } elseif ($status == 2) {

            // 待使用
            $query = $query->where('status', 8);

        } elseif ($status == 3) {

            $query = $query->whereIn('status', [2, 3]);

        } elseif ($status == 4) {

            $query = $query->where('status', 4);

        }

        $list = $query->orderBy('id', 'desc')->paginate(10000);

        return $this->success(OrderResource::collection($list));

    }

    public function buyCreate(Request $request)
    {

        $user_id = auth('weapp')->id();

        $sku = ProductSku::find($request->product_sku_id);

        $total_amount = $sku->price * $request->amount;

        $product = Product::find($request->product_id);

        if ($request->amount > $sku->stock && $product->is_online == 1) {
            return $this->failed('您选购的' . $product->name . '商品' . $sku->title . '型号库存仅剩余' . $sku->stock . '件，无法下单');
        }

        $order_data = [
            'no' => 'BUY' . date('YmdHis', time()) . random_int(100000, 999999),
            'user_id' => $user_id,
            'total_amount' => $total_amount,
            'status' => 1,
            'store_id' => $request->store_id
        ];

        $order = Order::create($order_data);

        if($product->is_online == 1){
            $sku->update(['stock' => ($sku->stock - $request->amount)]);
        }

        $item_data = [
            'order_id' => $order->id,
            'product_id' => $request->product_id,
            'product_name' => Product::find($request->product_id)->name,
            'title' => $sku->title,
            'product_sku_id' => $request->product_sku_id,
            'store_id' => $request->store_id,
            'amount' => $request->amount,
            'price' => $sku->price,
            'user_id' => $user_id
        ];

        OrderItem::create($item_data);

        if($product->is_online != 1){

            (new Order())->generateQrCode($order->id);  // 生成二维码

        }

        return $this->success(['order_id' => $order->id]);

    }

    public function checkOrder(Request $request)
    {

        $order = Order::find($request->id);

        return view('check',['order'=>$order]);

    }

    public function confirmCheck(Request $request)
    {

        $order = Order::find($request->id);

        if($order->status != 8){
            return $this->failed('当前订单状态无法进行核销操作');
        }

        $order->update(
            [
                'finish_at' => now(),
                'status' => 9
            ]
        );

        (new Order())->dealAfterRecieve($order);

        return $this->success();

    }

    public function cartCreate(Request $request)
    {

        $user_id = auth('weapp')->id();

        $order_data = [
            'no' => 'BUY' . date('YmdHis', time()) . random_int(100000, 999999),
            'user_id' => $user_id,
            'total_amount' => $request->total_amount,
            'status' => 1
        ];

        $list = CartItem::whereIn('id', $request->cart_item_ids)->get()->toArray();

        foreach ($list as $k => $v) {

            $sku = ProductSku::find($v['product_sku_id']);

            $product = Product::find($v['product_id']);

            if ($v['amount'] > $sku->stock && $product->is_online == 1) {
                return $this->failed('您选购的' . $product->name . '商品' . $sku->title . '型号库存仅剩余' . $sku->stock . '件，无法下单');
            }

            $order_data['store_id'] = $v['store_id'];

        }

        $order = Order::create($order_data);

        foreach ($list as $k => $v) {

            $sku = ProductSku::find($v['product_sku_id']);

            if($product->is_online == 1){
                $sku->update(['stock' => ($sku->stock - $v['amount'])]);
            }

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

        }

        if($product->is_online != 1){

            (new Order())->generateQrCode($order->id);  // 生成二维码

        }

        return $this->success(['order_id' => $order->id]);

    }

    public function info(Request $request)
    {

        $order = Order::find($request->id);

        return $this->success(new OrderResource($order));

    }

    public function submit(Request $request)
    {


    }

    public function generatePay(Request $request)
    {

        $order = Order::find($request->id);

        $order->update(
            [
                'use_deposit' => 2
            ]
        );

        $user = User::find($order->user_id);

        $order = [
            'out_trade_no' => $order->no,
            'body' => '购买商品',
            'total_fee' => $order->total_amount * 100,
            'openid' => $user->open_id
        ];

        $result = Pay::wechat(config('pay.wechat'))->miniapp($order);

        return $this->success(['payment' => $result]);

    }

    public function depositPay(Request $request)
    {

        $order = Order::find($request->id);

        $user = User::find($order->user_id);

        if ($user->remain_money < $order->total_amount) {
            return $this->failed('余额不足，请充值');
        }

        $user->update(['remain_money' => ($user->remain_money - $order->total_amount)]);

        $order->update(
            [
                'use_deposit' => 1,
                'pay_at' => now(),
                'status' => Store::find($order->store_id)->is_online == 1 ? 2 : 8    //2 待发货 8线下待使用
            ]
        );

        return $this->success();

    }

    public function deposit(Request $request)
    {

        $setting = DepositSetting::find($request->chosen_id);

        $data = $request->all();

        $data['out_trade_no'] = 'CHONGZHI' . time() . random_int(100000, 999999);

        $data['user_id'] = auth('weapp')->id();

        $data['status'] = 1;

        $data['deposit_money'] = $setting->deposit_money;

        $data['money'] = $setting->give_money + $setting->deposit_money;

        Deposit::create($data);

        $user = User::find($data['user_id']);

        $order = [
            'out_trade_no' => $data['out_trade_no'],
            'body' => '平台充值',
            'total_fee' => $setting->deposit_money * 100,
            'openid' => $user->open_id
        ];

        $result = Pay::wechat(config('pay.wechat'))->miniapp($order);

        return $this->success(['payment' => $result]);

    }

    public function confirmRecieve(Request $request)
    {

        $user_id = auth('weapp')->id();

        $order = Order::find($request->id);

        if ($order->status != 3) {
            return $this->failed('当前订单状态无法进行确认收货操作');
        }

        $order->update(
            [
                'finish_at' => now(),
                'status' => 4
            ]
        );

        (new Order())->dealAfterRecieve($order);

        // 处理推手逻辑，给一级推手，二级推手加余额

        return $this->success();

    }

    public function evalue(Request $request)
    {

        if (empty($request->input('content'))) {
            return $this->failed('请填写评价内容');
        }

        $order = Order::find($request->id);

        $evalue = Evalue::create([
            'rate' => $request->rate,
            'content' => $request->input('content'),
            'attaches' => $request->attaches,
            'store_id' => $order->store_id,
            'order_id' => $order->id,
            'user_id' => auth('weapp')->id()
        ]);

        $products = [];

        foreach ($order->items as $k => $v) {

            $products[] = $v['product_id'];

        }

        foreach (array_unique($products) as $k => $v) {

            $product = Product::find($v);

            $evalues = $product->evalues ? $product->evalues : [];

            $evalues[] = $evalue->id;

            $product->update(['evalues' => $evalues,'evalue'=>($product->evalue+1)]);

        }

        $order->update(
            [
                'evalue_at' => now(),
                'status' => 5
            ]
        );

        return $this->success();

    }

    public function submitRefund(Request $request)
    {

        $order = Order::find($request->id);

        if($order->status != 3 && $order->status != 2 && $order->status != 8){

            return $this->failed('当前订单无法申请退款');

        }

        $order->update(
            [
                'refund_start_at'=>now(),
                'status'=>6,
            ]
        );

        return $this->success();

    }

}
