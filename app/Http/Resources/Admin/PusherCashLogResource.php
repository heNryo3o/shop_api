<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PusherCashLogResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'status' => $this->status,
            'mobile' => $this->user->mobile,
            'nickname' => $this->user->nickname,
            'created_at' => $this->created_at->toDateTimeString(),
            'money' => $this->money,
            'user_id' => $this->user_id
        ];

    }

}
