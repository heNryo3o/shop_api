<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{

    public function rules()
    {

        if(strpos($this->route()->uri(),'edit') !== false){

            return [
                'id'=> 'required | exists:roles',
                'name' => 'required | max:15 | min:2 | unique:roles,id,'.$this->id,
                'describe' => 'required | max:255 | min:4',
                'status' => 'required | int',
                'permissions' => 'required | array'
            ];

        }else{

            return [
                'name' => 'required | max:15 | min:2 | unique:roles',
                'describe' => 'required | max:255 | min:4',
                'status' => 'required | int',
                'permissions' => 'required | array'
            ];

        }

    }

}
