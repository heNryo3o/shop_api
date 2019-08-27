<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\PushRequest;
use App\Http\Resources\Admin\PushLogResource;
use App\Http\Resources\Admin\PushResource;
use App\Models\Push;
use App\Models\PushLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Push::filter($request->all())->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(PushResource::collection($list));

    }

    public function create(PushRequest $request)
    {

        $data = (new Push())->dealPushType($request->all());

        Push::create($data);

        return $this->success();

    }

    public function edit(PushRequest $request)
    {

        $data = (new Push())->dealPushType($request->all());

        Push::find($request->id)->update($data);

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        Push::find($request->id)->update(['status'=>$request->status]);

        return $this->success();

    }

    public function destroy(DestroyRequest $request)
    {

        Push::destroy($request->id);

        return $this->success();

    }

    public function moduleOptions()
    {

        $list = Push::groupBy('module')->remember(14000)->get(['module'])->toArray();

        $options = $this->dealOptions($list,'module','module');

        return $this->success($options);

    }

    public function logs(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = PushLog::filter($request->all())->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(PushLogResource::collection($list));

    }

    public function typeOptions()
    {

        $list = Push::remember(10080)->get(['type'])->toArray();

        $options = $this->dealOptions($list,'type','type');

        return $this->success($options);

    }

}
