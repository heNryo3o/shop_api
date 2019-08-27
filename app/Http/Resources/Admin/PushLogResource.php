<?php

namespace App\Http\Resources\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PushLogResource extends JsonResource
{

    public function toArray($request)
    {

        $user = $admin = null;

        if($this->user_id > 0){
            $user = User::where('id',$this->user_id)->remember(10080)->first();
        }

        if($this->admin_id > 0){
            $admin = Admin::where('id',$this->admin_id)->remember(10080)->first();
        }

        return [
            'id' => $this->id,
            'type' => $this->type,
            'push_type' => $this->push_type,
            'viewed' => $this->viewed,
            'param_content' => $this->param_content,
            'param' => $this->param,
            'error' => $this->error,
            'result' => $this->result,
            'user_id' => $this->user_id,
            'admin_id' => $this->admin_id,
            'mobile'=>$user ? $user->mobile : '',
            'admin_name' =>$admin ? $admin->username : '',
            'created_at' => $this->created_at->toDateTimeString()
        ];

    }

}
