<?php

namespace App\Http\Requests\Weapp;

use App\Rules\MobileRule;
use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{

    public function rules()
    {

        $this->offsetSet('user_id', auth('weapp')->id());

        return [
            'linkman' => 'required',
            'mobile' => ['required', new MobileRule()],
            'address' => 'required',
            'is_default' => 'required'
        ];

    }

}
