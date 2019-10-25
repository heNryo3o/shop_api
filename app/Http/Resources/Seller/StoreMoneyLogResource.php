<?php

namespace App\Http\Resources\Seller;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreMoneyLogResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'store_id' => $this->store_id,
            'earn_money' => $this->earn_money,
            'created_at' => $this->created_at->toDateTimeString(),
            'order_id' => $this->order_id,
            'retail_1' => $this->retail_1,
            'retail_2' => $this->retail_2,
            'order_money' => $this->order_money,
            'cost_money' => $this->cost_money,
            'order_no' => Order::find($this->order_id)->no
        ];

    }

}
