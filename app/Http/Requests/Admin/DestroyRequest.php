<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{

    public function rules()
    {

        return [
            'id' => 'required | int'
        ];

    }

}
