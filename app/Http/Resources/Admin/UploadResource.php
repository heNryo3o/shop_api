<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'table' => $this->table,
            'item_id' => $this->item_id,
            'file_url' => $this->file_url,
            'origin' => $this->origin,
            'ip' => $this->ip,
            'created_at' => $this->created_at->toDateTimeString(),
            'full_url' => $this->full_url,
            'is_admin' => $this->is_admin
        ];

    }

}
