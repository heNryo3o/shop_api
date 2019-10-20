<?php

namespace App\Http\Resources\Admin;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {

        $category = Category::where(['id'=>$this->category_id])->remember(10080)->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->toDateTimeString(),
            'price' => $this->price,
            'retail_1' => $this->retail_1,
            'retail_2' => $this->retail_2,
            'thumb' => $this->thumb,
            'content' => $this->content,
            'category_id' => $this->category_id,
            'category_name' => $category['name'],
            'sold' => $this->sold,
            'browse' => $this->browse,
            'store_id' => $this->store_id,
            'status' => $this->status,
            'skus' => $this->skus,
            'category' => $this->category,
            'attention' => $this->attention,
            'is_online' => $this->is_online,
            'store_name' => $this->store->name,
            'is_dapai' => $this->is_dapai
        ];

    }

}
