<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->toDatetimeString(),
            'username'=>$this->username,
            'status' => $this->status,
            'mobile' => $this->mobile,
            'licence' => $this->licence,
            'id_card' => $this->id_card,
            'id_card_back' => $this->id_card_back,
            'category' => $this->category,
            'area' => $this->area,
            'address' => $this->address,
            'bank_card' => $this->bank_card,
            'collect' => $this->collect,
            'logo' => $this->logo,
            'thumb' => $this->thumb,
            'evalue' => $this->evalue,
            'is_online' => $this->is_online,
            'browse' => $this->browse,
            'shangquan' => $this->shangquan,
            'rate' => $this->rate,
            'average_cost' => $this->average_cost,
            'category_name' => $this->category_name,
            'area_name' => $this->area_name,
            'state' => $this->state,
            'money' => $this->money,
            'money_block' => $this->money_block,
            'money_hold' => $this->money_hold,
            'money_total' => $this->money_total,
            'open_time' => $this->open_time,
            'fuli' => $this->fuli ? $this->fuli : []
        ];

    }

}
