<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{

    public function toArray($request)
    {

        $roles = $this->roles->toArray();

        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'key' => $this->key,
            'created_at' => $this->created_at->toDateTimeString(),
            'status' => $this->status,
            'roles_name' => array_column($roles,'name'),
            'roles' => array_column($roles,'id')
        ];

    }

}
