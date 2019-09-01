<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'mobile' => $this->user->mobile,
            'image' => $this->image,
            'name' => $this->name,
            'store_name' => $this->store->name,
            'created_at' => $this->created_at->toDateTimeString(),
            'status' => $this->status
        ];

    }

}
