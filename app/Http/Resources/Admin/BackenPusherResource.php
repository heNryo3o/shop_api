<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BackenPusherResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'mobile' => $this->mobile,
            'created_at' => $this->created_at->toDateTimeString()
        ];

    }

}
