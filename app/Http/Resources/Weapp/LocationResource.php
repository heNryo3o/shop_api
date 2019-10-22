<?php

namespace App\Http\Resources\Weapp;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'created_at' => $this->created_at->toDateTimeString(),
            'user_id' => $this->user_id,
            'address' => $this->address,
            'address_detail' => $this->address_detail,
            'is_default' => $this->is_default,
            'mobile' => $this->mobile,
            'linkman' => $this->linkman
        ];

    }

}
