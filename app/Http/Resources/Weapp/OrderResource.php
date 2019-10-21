<?php

namespace App\Http\Resources\Weapp;

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
            'order_date' => $this->order_date,
            'total_amount' => $this->total_amount
        ];

    }

}
