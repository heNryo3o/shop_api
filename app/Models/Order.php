<?php

namespace App\Models;

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
        'refund_end_at'
    ];

    protected $appends = ['state','items','order_date','user_remain_money'];

    public function getUserRemainMoneyAttribute()
    {

        return User::find($this->user_id)->remain_money;

    }

    public function dealNotify($out_trade_no,$fee)
    {

        $order = Order::where(['no'=>$out_trade_no])->first();

        if($fee == $order->total_amount*100){
            $order->update(
                [
                    'use_deposit' => 1,
                    'payed_at' => now(),
                    'status' => Store::find($order->store_id)->is_online == 1 ? 2 :8    //2 待发货 8线下待使用
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
            return '已退款';
        }elseif($this->status == 7){
            return '已退款';
        }elseif($this->status == 8){
            return '未使用';
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
