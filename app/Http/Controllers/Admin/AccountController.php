<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\CouponLogResource;
use App\Http\Resources\Admin\PayLogResource;
use App\Http\Resources\Admin\PusherCashLogResource;
use App\Http\Resources\Admin\StoreCashLogResource;
use App\Models\Coupon;
use App\Models\CouponLog;
use App\Models\PayLog;
use App\Models\PusherCashLog;
use App\Models\Store;
use App\Models\StoreCashLog;
use App\Models\User;
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

    public function pusherCashIndex(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = PusherCashLog::filter($request->all())->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(PusherCashLogResource::collection($list));

    }

    public function pusherCashAudit(Request $request)
    {

        $log = PusherCashLog::find($request->id);

        if($log->status != 1){
            return $this->failed('当前记录状态无法被审核，请刷新后重试');
        }

        $user = User::find($log->user_id);

        if($request->status == 2){

            // 审核通过，扣减冻结余额，和总余额
            $user->update([
                'money' => $user->money - $log->money,
                'money_block' => $user->money_block - $log->money
            ]);

            $log->update(['status'=>2]);

        }

        if($request->status == 3){

            // 审核失败，扣减冻结余额
            $user->update([
                'money_block' => $user->money_block - $log->money
            ]);

            $log->update(['status'=>3]);

        }

        return $this->success();

    }

    public function storeCashIndex(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = StoreCashLog::filter($request->all())->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(StoreCashLogResource::collection($list));

    }

    public function storeCashAudit(Request $request)
    {

        $log = StoreCashLog::find($request->id);

        if($log->status != 1){
            return $this->failed('当前记录状态无法被审核，请刷新后重试');
        }

        $store = Store::find($log->store_id);

        if($request->status == 2){

            // 审核通过，扣减冻结余额，和总余额
            $store->update([
                'money' => $store->money - $log->money,
                'money_block' => $store->money_block - $log->money
            ]);

            $log->update(['status'=>2]);

        }

        if($request->status == 3){

            // 审核失败，扣减冻结余额
            $store->update([
                'money_block' => $store->money_block - $log->money
            ]);

            $log->update(['status'=>3]);

        }

        return $this->success();

    }

    public function couponIndex(Request $request)
    {

        $list = CouponLog::filter($request->all())->orderBy('id','desc')->paginate($request->limit);

        return $this->success(CouponLogResource::collection($list));

    }

    public function couponCreate(Request $request)
    {

        $money = $request->money;

        CouponLog::create([
            'money' => $money
        ]);

        $users = User::all()->toArray();

        foreach ($users as $k => $v){

            Coupon::create([
                'user_id' => $v['id'],
                'status' => 1,
                'money' => $money
            ]);

        }

        return $this->success();

    }

}
