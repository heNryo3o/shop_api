<?php

namespace App\Http\Requests\Admin;

use App\Rules\MobileRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{

    public function rules()
    {

        if(strpos($this->route()->uri(),'edit') !== false){

            return [
                'id' => 'required | int | exists:admins',
                'true_name' => 'required',
                'username' => ['required', 'unique:admins,id,'.$this->id, new MobileRule()],
                'status' => 'required | int',
                'roles_id' => 'required | array',
                'permissions' => 'required | array'
            ];

        }else{

            return [
                'true_name' => 'required',
                'username' => ['required', 'unique:admins', new MobileRule()],
                'status' => 'required | int',
                'roles_id' => 'required | array',
                'permissions' => 'required | array'
            ];

        }

    }

    public function attributes()
    {
        return [
            'username' => '手机号码',
            'true_name' => '姓名',
            'roles_id' => '角色',
            'permissions' => '权限项',
        ];
    }

}
