<?php

namespace App\Http\Resources\Admin;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{

    public function toArray($request)
    {

        $roles = $this->roles->toArray();

        $roles_name = array_column($roles,'name');

        $roles_id = array_column($roles,'id');

        $permissions = [];

        $permission_list = Role::whereIn('id',$roles_id)->get();

        if($permission_list){
            foreach ($permission_list as $k => $v){
                foreach ($v->permissions->toArray() as $vk => $vv){
                    $permissions[] = $vv;
                }
            }
        }

        $permissions_id = array_column($permissions,'id');

        $permissions_key = in_array(1,$roles_id) ? ['super_admin'] : array_column($permissions,'key');

        return [
            'id' => $this->id,
            'username' => $this->username,
            'true_name' => $this->true_name,
            'roles_id' => $roles_id,
            'roles' => $permissions_key,
            'roles_name' => $roles_name,
            'permissions' => $permissions_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'status' => $this->status,
            'avatar' => $this->avatar ? $this->avatar : 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif?imageView2/1/w/80/h/80'
        ];

    }

}
