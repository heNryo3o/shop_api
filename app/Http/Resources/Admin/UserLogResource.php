<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserLogResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'uid' => $this->uid,
            'mobile' => $this->mobile,
            'type' => $this->type,
            'origin' => $this->origin,
            'ip' => $this->ip,
            'browser' => $this->browser,
            'created_at' => $this->created_at->toDateTimeString(),
        ];

    }

}
