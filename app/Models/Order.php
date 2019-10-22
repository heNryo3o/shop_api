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
        'paid_at',
        'payment_method',
        'payment_no',
        'refund_status',
        'refund_no',
        'closed',
        'reviewed',
        'ship_status',
        'status',
        'store_id',
        'linkman',
        'mobile',
        'use_deposit',
        'location_id'
    ];

    protected $appends = ['state','items','order_date','user_remain_money'];

    public function getUserRemainMoneyAttribute()
    {

        return User::find($this->user_id)->remain_money;

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
