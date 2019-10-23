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
            'avatar' => $this->avatar,
            'is_pusher' => $this->is_pusher,
            'remain_money' => $this->remain_money,
            'money' => $this->money,
            'money_block' => $this->money_block,
            'parent_user_id' => $this->parent_user_id,
            'mobile' => $this->mobile
        ];

    }

}
