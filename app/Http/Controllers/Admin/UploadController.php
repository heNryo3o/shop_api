<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\UploadRequest;
use App\Http\Resources\Admin\UploadResource;
use App\Models\Upload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Upload::filter($request->all())->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(UploadResource::collection($list));

    }

    public function create(UploadRequest $request)
    {

        Upload::create($request->all());

        return $this->success();

    }

    public function edit(UploadRequest $request)
    {

        Upload::find($request->id)->update($request->all());

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        Upload::find($request->id)->update(['status'=>$request->status]);

        return $this->success();

    }

    public function destroy(DestroyRequest $request)
    {

        Upload::destroy($request->id);

        return $this->success();

    }

}
