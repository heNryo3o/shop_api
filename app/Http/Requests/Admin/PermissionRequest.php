<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{

    public function rules()
    {

        if(strpos($this->route()->uri(),'edit') !== false){

            return [
                'id'=> 'required | exists:permissions',
                'key' => 'required | unique:permissions,id,'.$this->id,
                'name' => 'required | max:15 | min:2 | unique:roles,id,'.$this->id,
                'status' => 'required | int'
            ];

        }else{

            return [
                'name' => 'required | max:15 | min:2 | unique:roles',
                'key' => 'required | unique:permissions',
                'status' => 'required | int'
            ];

        }

    }

    public function attributes()
    {
        return [
            'key' => '权限键值',
            'name' => '权限名'
        ];
    }

}
