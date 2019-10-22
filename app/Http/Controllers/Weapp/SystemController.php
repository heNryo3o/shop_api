<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\DepositSetting;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use JMessage\IM\Report;
use JMessage\JMessage;
use Yansongda\LaravelPay\Facades\Pay;
use Yansongda\Pay\Log;

class SystemController extends Controller
{

    public function banners()
    {

        $setting = Setting::find(1);

        return $this->success(['list'=>$setting->banners,'single'=>$setting->ad_pic]);

    }

    public function chatLog(Request $request)
    {

        $report = new Report(new JMessage(config('jim.key'), config('jim.secret')));

        $end = date('Y-m-d H:i:s',time());

        $start = date('Y-m-d H:i:s',time()-86400*7);

        $response = $report->getUserMessages('kefu_2', 1000, $start, $end);

        return $this->success($response['body']);

    }

    public function notify()
    {
        $pay = Pay::wechat(config('pay.wechat'));

        try{
            $data = $pay->verify(); // 是的，验签就这么简单！

            if($data->result_code === 'SUCCESS') {
                if(substr($data->out_trade_no,0,3) == 'BUY'){
                    (new Order())->dealNotify($data->out_trade_no,$data->cash_fee);
                }elseif(substr($data->out_trade_no,0,5) == 'CHONG'){
                    (new Order())->dealDeposit($data->out_trade_no,$data->cash_fee);
                }
            }

            Log::debug('Wechat notify', $data->all());

        } catch (\Exception $e) {
            // $e->getMessage();
        }

        return $pay->success();// laravel 框架中请直接 `return $pay->success()`
    }

    public function depositSetting()
    {

        $list = DepositSetting::all();

        return $this->success(['list'=>$list]);

    }

}
