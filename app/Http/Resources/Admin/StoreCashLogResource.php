<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreCashLogResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'status' => $this->status,
            'mobile' => $this->store->mobile,
            'name' => $this->store->name,
            'created_at' => $this->created_at->toDateTimeString(),
            'money' => $this->money,
            'store_id' => $this->store_id
        ];

    }

}
