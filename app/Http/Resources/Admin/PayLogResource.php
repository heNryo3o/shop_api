<?php

namespace App\Http\Resources\Admin;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PayLogResource extends JsonResource
{

    public function toArray($request)
    {

        $user = User::find($this->user_id);

        return [
            'id' => $this->id,
            'money' => $this->money,
            'created_at' => $this->created_at->toDateTimeString(),
            'type' => $this->type,
            'user_id' => $this->user_id,
            'mobile' => $user->mobile,
            'nickname' => $user->nickname
        ];

    }

}
