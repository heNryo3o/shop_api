<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\PayLogResource;
use App\Models\PayLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{

    public function payLog(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = PayLog::filter($request->all())->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(PayLogResource::collection($list));

    }

}
