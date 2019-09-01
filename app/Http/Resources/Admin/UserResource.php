<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'nickname' => $this->nickname,
            'created_at' => $this->created_at->toDateTimeString(),
            'status' => $this->status,
        ];

    }

}
