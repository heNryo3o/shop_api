<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Resources\Admin\PermissionResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Permission::filter($request->all())->remember(10080)->with('roles:roles.id,roles.name')->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(PermissionResource::collection($list));

    }

    public function create(PermissionRequest $request)
    {

        $permission = Permission::create($request->all());

        $permission->roles()->sync($request->roles);

        return $this->success();

    }

    public function edit(PermissionRequest $request)
    {

        Permission::find($request->id)->roles()->sync($request->roles);

        Permission::find($request->id)->update($request->all());

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        Permission::find($request->id)->update(['status' => $request->status]);

        return $this->success();

    }

    public function destroy(DestroyRequest $request)
    {

        Permission::destroy($request->id);

        return $this->success();

    }

    public function calPermissions(Request $request)
    {

        $roles = $request->roles;

        $role_permissions = $admin_permissions = [];

        // 先获取角色拥有的权限

        if($roles){

            $roles = Role::whereIn('id', $roles)->where(['status' => 1])->with('permissions:permissions.id')->remember(10080)->get()->toArray();

            foreach ($roles as $k => $v) {

                $role_permissions = array_merge($role_permissions, array_column($v['permissions'], 'id'));

            }

        }

        $permissions = array_filter(array_unique($role_permissions));

        return $this->success(['permissions' => $permissions]);

    }

    public function permissionOptions()
    {

        $list = Permission::where(['parent_id' => null])->remember(10080)->get(['id', 'name'])->toArray();

        foreach ($list as $k => &$v) {

            $v['children'] = Permission::where(['parent_id' => $v['id']])->remember(14000)->get(['id', 'name'])->toArray();

        }

        $options = $this->dealOptions($list, 'id', 'name');

        return $this->success($options);

    }

    public function parentOptions()
    {

        $list = Permission::where(['parent_id' => null])->remember(10080)->get(['id', 'name'])->toArray();

        $options = $this->dealOptions($list, 'id', 'name');

        return $this->success($options);

    }

}
