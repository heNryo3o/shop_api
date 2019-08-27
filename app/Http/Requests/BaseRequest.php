<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{

    /**
     * 在这里定义全站的验证报错提示语
     * @return array
     */

    public function messages()
    {
        return [

        ];
    }

}
