<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'username' => $this->username,
            'true_name' => $this->true_name,
            'created_at' => $this->created_at->toDateTimeString(),
            'status' => $this->status,
            'roles' => ['super_admin'],
            'avatar' => $this->avatar ? $this->avatar : 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif?imageView2/1/w/80/h/80'
        ];

    }

}
