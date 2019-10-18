<?php

namespace App\Http\Requests\Seller;

use App\Rules\MobileRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    public function rules()
    {
        if(strpos($this->route()->uri(),'edit') !== false){
            return [
                'name'=>'required',
                'mobile'=>['required',new MobileRule()],
                'area'=>'required',
                'address'=>'required',
                'category'=>'required',
                'licence'=>'required',
                'id_card'=>'required',
                'id_card_back'=>'required',
                'bank_card'=>'required'
            ];

        }else{

            return [
                'name'=>'required',
                'mobile'=>['required',new MobileRule(),'unique:stores'],
                'area'=>'required',
                'address'=>'required',
                'category'=>'required',
                'licence'=>'required',
                'id_card'=>'required',
                'id_card_back'=>'required',
                'bank_card'=>'required'
            ];
        }

    }

}
