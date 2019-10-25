<?php

namespace App\Http\Requests\Admin;

use App\Rules\MobileRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditLoginRequest extends FormRequest
{

    public function rules()
    {

        return [
            'id' => 'required | int | exists:admins',
            'true_name' => 'required',
            'username' => ['required', 'unique:admins,id,'.$this->id, new MobileRule()]
        ];

    }

    public function attributes()
    {
        return [
            'username' => '手机号码',
            'true_name' => '姓名'
        ];
    }

}
