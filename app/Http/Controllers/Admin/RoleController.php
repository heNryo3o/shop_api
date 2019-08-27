<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Role::filter($request->all())->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(RoleResource::collection($list));

    }

    public function create(RoleRequest $request)
    {

        $role = Role::create($request->all());

        $role->permissions()->sync($request->permissions);

        return $this->success();

    }

    public function edit(RoleRequest $request)
    {
        $role = Role::find($request->id);

        $role->permissions()->sync($request->permissions);

        $role->update($request->all());

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        Role::find($request->id)->update(['status' => $request->status]);

        return $this->success();

    }

    public function destroy(DestroyRequest $request)
    {

        Role::destroy($request->id);

        return $this->success();

    }

    public function roleOptions()
    {

        $list = Role::get(['id', 'name'])->toArray();

        $options = $this->dealOptions($list, 'id', 'name');

        return $this->success($options);

    }

}
