<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{

    public function toArray($request)
    {

        $permissions = $this->permissions->toArray();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'describe' => $this->describe,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'status' => $this->status,
            'permissions' => array_column($permissions,'id')
        ];

    }

}
