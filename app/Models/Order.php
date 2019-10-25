<?php

namespace App\Models;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Order extends PublicModel
{

    protected $fillable = [
        'no',
        'user_id',
        'address',
        'total_amount',
        'remark',
        'pay_at',
        'created_at',
        'updated_at',
        'status',
        'store_id',
        'mobile',
        'linkman',
        'use_deposit',
        'location_id',
        'send_at',
        'finish_at',
        'evalue_at',
        'refund_start_at',
        'refund_end_at',
        'coupon_id',
        'use_coupon',
        'coupon_money',
        'real_money'
    ];

    protected $appends = ['state','items','order_date','user_remain_money','qr_src'];

    public function dealAfterRecieve($order)
    {

        $user_id = $order->id;

        $items = $order->items;

        $store = Store::find($order->store_id);

        // 更新统计信息，店铺销量，产品销量，产品销售额，店铺销售额，商家可提现余额，

        $products = [];

        $sold_num = 0;

        foreach ($items as $k => $v) {

            if (isset($products[$v['product_id']])) {

                $products[$v['product_id']] += $v['amount'];

            } else {

                $products[$v['product_id']] = $v['amount'];

            }

            $sold_num += $v['amount'];

        }

        $store_money = $order->total_amount;

        $setting = Setting::find(1);

        $store_money = $setting->rate * $store_money / 100;

        $retail_total_1 = $retail_total_2 = 0;

        foreach ($products as $k => $v) {

            $product = Product::find($k);

            $product->update(['sold' => ($product->sold + $v), 'sold_user' => ($product->sold_user + 1)]);

            $recommen = RecommenLog::where(['product_id' => $k, 'get_user_id' => $user_id])->orderBy('id', 'desc')->first();

            if ($recommen) {

                $push_user = User::find($recommen->push_user_id);

                $push_user->update(['money' => ($push_user->money + $v * $product->retail_1)]);

                PusherLog::create([
                    'level' => 1,
                    'retail' => $product->retail_1 * $v,
                    'num' => $v,
                    'product_id' => $product->id,
                    'push_user_id' => $recommen->push_user_id,
                    'buy_user_id' => $user_id
                ]);

                $retail_total_1 += $product->retail_1 * $v;

                $store_money -= $product->retail_1 * $v;

                if ($push_user->parent_user_id) {

                    $parent_user = User::find($push_user->parent_user_id);

                    $parent_user->update(['money' => ($parent_user->money + $v * $product->retail_2)]);

                    PusherLog::create([
                        'level' => 2,
                        'retail' => $product->retail_2,
                        'product_id' => $product->id,
                        'push_user_id' => $push_user->parent_user_id,
                        'buy_user_id' => $user_id
                    ]);

                    $retail_total_2 += $product->retail_2 * $v;

                    $store_money -= $product->retail_2 * $v;

                }else{

                    // 如果没有团推，还是要扣钱，到平台

                    $retail_total_2 += $product->retail_2 * $v;

                    $store_money -= $product->retail_2 * $v;

                }

            }else{

                $retail_total_1 += $product->retail_1 * $v;

                $store_money -= $product->retail_1 * $v;

                $retail_total_2 += $product->retail_2 * $v;

                $store_money -= $product->retail_2 * $v;

            }

        }

        $store->update([
            'sold' => intval($store->sold) + $sold_num,
            'money_total' => $store->money_total + $order->total_amount,
            'money' => $store->money + $store_money
        ]);

        StoreMoneyLog::create(
            [
                'store_id' => $store->id,
                'earn_money' => $store_money,
                'order_id' => $order->id,
                'retail_1' => $retail_total_1,
                'retail_2' => $retail_total_2,
                'order_money' => $order->total_amount,
                'cost_money' => $order->total_amount * (100-$setting->rate)/100
            ]
        );

        return;

    }

    public function getQrSrcAttribute()
    {

        return asset('storage/order_qrs/'.$this->id.'.png');

    }

    public function getUserRemainMoneyAttribute()
    {

        return User::find($this->user_id)->remain_money;

    }

    public function generateQrCode($order_id)
    {

        QrCode::format('png')->size(300)->generate('https://api.jiangsulezhong.com/weapp/order/check-order?id='.$order_id,'storage/order_qrs/'.$order_id.'.png');

        return;

    }

    public function dealNotify($out_trade_no,$fee)
    {

        $order = Order::where(['no'=>$out_trade_no])->first();

        $amount = $order->total_amount;

        if($order->coupon_id > 0){

            $coupon = Coupon::find($order->coupon_id);

            if($coupon->status == 1){

                $amount = $order->real_money;

            }

        }

        if($fee == $amount*100){
            $order->update(
                [
                    'use_deposit' => 1,
                    'payed_at' => now(),
                    'status' => Store::find($order->store_id)->is_online == 1 ? 2 :8    //2 待发货 8线下待使用
                ]
            );

            if($coupon){

                $coupon->update(['status'=>2]);

            }

            PayLog::create(
                [
                    'user_id' => $order->user_id,
                    'money' => $order->total_amount,
                    'type' => 2,
                    'order_id' => $order->id
                ]
            );

        }

        return;

    }

    public function dealDeposit($out_trade_no, $fee)
    {

        $deposit = Deposit::where(['out_trade_no'=>$out_trade_no])->get()->first()->toArray();

        if($deposit['deposit_money']*100 == $fee){

            Deposit::find($deposit['id'])->update([
                'payed_money' => $fee/100,
                'pay_at' => now(),
                'status' => 2
            ]);

            $user = User::find($deposit['user_id']);

            RemainLog::create(
                [
                    'user_id' => $deposit['user_id'],
                    'money' => $deposit['money'],
                    'type' => 1,
                    'order_id' => 0
                ]
            );

            PayLog::create(
                [
                    'user_id' => $deposit['user_id'],
                    'money' => $deposit['deposit_money'],
                    'type' => 1,
                    'order_id' => 0
                ]
            );

            $user->update(['remain_money' => ($user->remain_money + $deposit['money'])]);

        }

        return;

    }

    public function getStateAttribute()
    {

        if($this->status == 1){
            return '待付款';
        }elseif($this->status == 2){
            return '等待发货';
        }elseif($this->status == 3){
            return '等待收货';
        }elseif($this->status == 4){
            return '待评价';
        }elseif($this->status == 5){
            return '已评价';
        }elseif($this->status == 6){
            return '退款中';
        }elseif($this->status == 7){
            return '已退款';
        }elseif($this->status == 8){
            return '未使用';
        }elseif($this->status == 9){
            return '已使用';
        }

    }

    public function getOrderDateAttribute()
    {
        return date('Y-m-d',strtotime($this->created_at->toDateTimeString()));
    }

    public function getItemsAttribute()
    {

        $list = OrderItem::where('order_id',$this->id)->get()->toArray();

        $items = [];

        foreach ($list as $k => $v){

            $product = Product::find($v['product_id']);

            $items[] = [
                'id' => $v['id'],
                'price' => $v['price'],
                'title' => $v['title'],
                'product_thumb' => $product->thumb,
                'product_id' => $v['product_id'],
                'product_name' => $product->name,
                'amount' => $v['amount']
            ];

        }

        return $items;

    }

}
