<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Rules\MobileRule;

/**
 * 验证登录请求参数
 * Class LoginRequest
 * @package App\Http\Requests\Admin
 */
class LoginRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'username' => [
                'required',
                'exists:admins',
                new MobileRule()
            ],
            'password' => 'required | min: 6 | max: 20',
        ];
    }
}
