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
            'created_at' => $this->created_at->toDateTimeString(),
            'parent_id' => $this->parent_id,
            'admin_id' => $this->admin_id,
            'admin_name' => $this->admin ? $this->admin->true_name : '',
            'level' => $this->level,
            'status' => $this->status
        ];

    }

}
