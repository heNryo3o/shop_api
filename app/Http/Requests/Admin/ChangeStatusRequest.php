<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
{

    public function rules()
    {

        return [
            'id' => 'required | int',
            'status' => 'required | int'
        ];

    }

}
