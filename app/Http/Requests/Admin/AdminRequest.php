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
                'username' => [
                    'required',
                    'min: 2',
                    'max:10',
                    Rule::unique('admins')->ignore($this->id)->where('status', 1)
                ],
                'true_name' => 'required',
                'mobile' => ['required', 'unique:admins,id,'.$this->id, new MobileRule()],
                'department' => 'required | max: 10 | min:2 ',
                'status' => 'required | int'
            ];

        }else{

            return [
                'username' => [
                    'required',
                    'min: 2',
                    'max:10',
                    Rule::unique('admins')->ignore($this->id)->where('status', 1)
                ],
                'true_name' => 'required',
                'mobile' => ['required', 'unique:admins', new MobileRule()],
                'department' => 'required | max: 10 | min:2 ',
                'status' => 'required | int'
            ];

        }

    }

    public function attributes()
    {
        return [
            'username' => '花名',
            'true_name' => '本名',
            'roles' => '角色'
        ];
    }

}
