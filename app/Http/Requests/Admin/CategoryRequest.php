<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    public function rules()
    {

        request()->offsetSet('admin_id', auth('admin')->id());

        return [
            'name' => 'required',
            'status' => 'required | int',
        ];

    }

}
