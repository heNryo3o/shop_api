<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function index(Request $request, Admin $admin)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = $admin->filter($request->all())->with(['roles:roles.id,name','permissions:permissions.id'])->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(AdminResource::collection($list));

    }

    public function create(AdminRequest $request)
    {

        $admin = Admin::create($request->all());

        $password_salt = Str::random(6);

        $password = $this->userPasswordEncode($admin->mobile, $admin->password_salt, $admin->id);

        $admin->update(['password' => $password, 'password_salt' => $password_salt]);

        $admin->roles()->sync($request->roles_id);

        $admin->permissions()->sync($request->permissions);

        return $this->success();

    }

    public function edit(AdminRequest $request)
    {

        $admin = Admin::find($request->id);

        $admin->roles()->sync($request->roles_id);

        $admin->permissions()->sync($request->permissions);

        $admin->update($request->all());

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        Admin::find($request->id)->update(['status'=>$request->status]);

        return $this->success();

    }

    public function departmentOptions()
    {

        $list = Admin::groupBy('department')->remember(10080)->get(['department'])->toArray();

        $options = $this->dealOptions($list, 'department', 'department');

        return $this->success($options);

    }

    public function adminOptions()
    {

        $list = Admin::where('status',1)->remember(10080)->get(['username','id'])->toArray();

        $options = $this->dealOptions($list,'id','username');

        return $this->success($options);

    }

}
