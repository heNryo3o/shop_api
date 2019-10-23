<?php

namespace App\Http\Requests\Weapp;

use App\Rules\MobileRule;
use Illuminate\Foundation\Http\FormRequest;

class BindMobileRequest extends FormRequest
{

    public function rules()
    {

        $user_id = auth('weapp')->id();

        return [
            'mobile' => ['required', new MobileRule(),'unique:users,mobile,'.$user_id],
        ];

    }

}
