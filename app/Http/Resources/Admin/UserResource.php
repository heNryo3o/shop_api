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
            'prefer' => $this->prefer,
            'prefer_name' => $this->prefer_name,
            'vip_level' => $this->vip_level,
            'vip_name' => $this->vip_name,
            'mobile' => $this->mobile,
            'canal' => $this->canal,
            'created_at' => $this->created_at->toDateTimeString(),
            'status' => $this->status,
        ];

    }

}
