<?php

namespace App\Http\Resources\Seller;

use App\Models\Store;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {

        $store = Store::find($this->store_id);

        return [
            'id' => $this->id,
            'created_at' => $this->created_at->toDateTimeString(),
            'store_name' => $store->name,
            'store_id' => $this->store_id,
            'no' => $this->no,
            'state' => $this->state,
            'status' => $this->status,
            'items' => $this->items,
            'pay_at' => $this->pay_at,
            'order_date' => $this->order_date,
            'total_amount' => $this->total_amount,
            'user_remain_money' => $this->user_remain_money,
            'can_use_deposit' => $this->total_amount <= $this->user_remain_money ? 1 : 2,
            'location_id' => $this->location_id,
            'address' => $this->address,
            'mobile' => $this->mobile,
            'linkman' => $this->linkman,
        ];

    }

}
