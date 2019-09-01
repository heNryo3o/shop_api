<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'mobile' => $this->user->mobile,
            'vip_name' => $this->user->vip_name,
            'phone' => $this->phone,
            'person' => $this->person,
            'address' => $this->address,
            'created_at' => $this->created_at->toDateTimeString(),
            'status' => $this->status
        ];

    }

}
