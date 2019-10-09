<?php

namespace App\Http\Resources\Weapp;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'collect' => $this->collect,
            'user_id' => $this->user_id,
            'logo' => $this->logo,
            'thumb' => $this->thumb,
            'evalue' => $this->evalue
        ];

    }

}
