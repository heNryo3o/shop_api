<?php

namespace App\Http\Requests\Admin;

use App\Rules\MobileRule;
use Illuminate\Foundation\Http\FormRequest;

class PusherAddRequest extends FormRequest
{

    public function rules()
    {

        return [
            'mobile' => ['required',new MobileRule(),'unique:backen_pushers']
        ];

    }

}
