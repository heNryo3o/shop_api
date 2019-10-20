<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function rules()
    {

        return [
            'name' => 'required',
            'content' => 'required',
            'category' => 'required',
            'thumb' => 'required',
            'retail_1' => 'required|numeric|max:8|min:5',
            'retail_2' => 'required|numeric|max:3|min:1',
            'skus' => 'required'
        ];

    }

    public function attributes()
    {

        return [
            'name' => '商品名称',
            'content' => '商品描述',
            'category' => '分类',
            'thumb' => '商品封面图',
            'retail_1' => '一级推广赏金',
            'retail_2' => '二级推广赏金',
            'skus' => '商品规格'
        ];

    }

}
