<?php

namespace App\Http\Resources\Admin;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponLogResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'money' => $this->money,
            'created_at' => $this->created_at->toDateTimeString()
        ];

    }

}
