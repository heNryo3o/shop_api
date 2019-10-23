<?php

namespace App\Http\Resources\Weapp;

use App\Models\Category;
use App\Models\User;
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
            'is_online' => $this->is_online,
            'is_dapai' => $this->is_dapai,
            'sold_user' => $this->sold_user,
            'evalues' => $this->evalues,
            'is_pusher' => auth('weapp')->id() ? User::find(auth('weapp')->id())->is_pusher : 2
        ];

    }

}
