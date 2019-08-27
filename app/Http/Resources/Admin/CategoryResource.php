<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'describe' => $this->describe,
            'created_at' => $this->created_at->toDateTimeString(),
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'type' => $this->type,
            'type_name' => $this->type_name,
            'admin_id' => $this->admin_id,
            'pinyin' => $this->pinyin,
            'level' => $this->level,
            'status' => $this->status,
        ];

    }

}
