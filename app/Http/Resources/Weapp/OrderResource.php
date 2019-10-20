<?php

namespace App\Http\Resources\Weapp;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'created_at' => $this->created_at->toDateTimeString(),
        ];

    }

}
