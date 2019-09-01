<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\CompanyValidateRequest;
use App\Http\Resources\Admin\CompanyValidateResource;
use App\Models\CompanyValidate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyValidateController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = CompanyValidate::filter($request->all())->with(['user:users.id,mobile', 'admin:admins.id,admins.username'])->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(CompanyValidateResource::collection($list));

    }

    public function create(CompanyValidateRequest $request)
    {

        CompanyValidate::create($request->all());

        return $this->success();

    }

    public function edit(CompanyValidateRequest $request)
    {

        CompanyValidate::find($request->id)->update($request->all());

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        $status = CompanyValidate::find($request->id)->status;

        if ($status !== 1) {
            return $this->failed('当前认证记录已审核，不可重复审核。');
        }

        if ($request->status == 3 && empty($request->msg)) {
            return $this->failed('请填写认证未通过原因');
        }

        CompanyValidate::find($request->id)->update(
            [
                'status' => $request->status,
                'audit_at' => now(),
                'admin_id' => auth('admin')->id(),
                'msg' => $request->msg
            ]
        );

        return $this->success();

    }

    public function destroy(DestroyRequest $request)
    {

        CompanyValidate::destroy($request->id);

        return $this->success();

    }

}
