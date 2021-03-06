<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLogResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'mobile' => $this->mobile,
            'type' => $this->type,
            'ip' => $this->ip,
            'created_at' => $this->created_at->toDateTimeString(),
        ];

    }

}
