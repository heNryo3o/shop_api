<?php

namespace App\Http\Requests\Seller;

use App\Rules\MobileRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangePasswordRequest extends FormRequest
{

    public function rules()
    {

        return [
            'password' => 'required|min:6|max:20'
        ];

    }

    public function attributes()
    {
        return [
            'password' => '密码'
        ];
    }

}
