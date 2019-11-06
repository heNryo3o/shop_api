<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\DepositSetting;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Store;
use App\Models\Upload;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use JMessage\IM\Report;
use JMessage\IM\Resource;
use JMessage\JMessage;
use Yansongda\LaravelPay\Facades\Pay;
use Yansongda\Pay\Log;
use Illuminate\Support\Facades\Storage;

class SystemController extends Controller
{

    public function banners()
    {

        $setting = Setting::find(1);

        return $this->success(['list'=>$setting->banners,'single'=>['pic'=>$setting->ad_pic,'type'=>$setting->ad_type,'target_id'=>$setting->ad_target_id]]);

    }

    public function chatLog(Request $request)
    {

        $jim = new JMessage(config('jim.key'), config('jim.secret'));

        $report = new Report($jim);

        $end = date('Y-m-d H:i:s',time());

        $start = date('Y-m-d H:i:s',time()-86400*7);

        $response = $report->getUserMessages($request->username, 1000, $start, $end);

        $resource =  new Resource($jim);

        if($response['body']['messages']){
            foreach ($response['body']['messages'] as $k => &$v){
                if(isset($v['msg_body']['media_id'])){
                    $media_res = $resource->download($v['msg_body']['media_id']);
                    $v['msg_body']['media_src'] = $media_res['body']['url'];
                }
            }
        }

        if(substr($request->username,0,4) == 'kefu'){

            $store_id = str_replace('kefu_','',$request->username);

            $avatar = Store::find($store_id)->logo;

            $response['body']['avatar'] = $avatar;

        }

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

    public function upload(Request $request)
    {

        $save = 'public/'.date('Y/m/d', time());

        $path = $request->file('file')->store($save);

        $url = Storage::url($path);

        $full_url = config('filesystems.default') == 'oss' ? config('filesystems.oss_url').$path : asset($url);

        $result = array(
            'preview_url' => $full_url,
            'file_url' => $path
        );

        return $this->success($result);

    }

    public function haibao(Request $request)
    {

        $app = Factory::miniProgram(config('wechat.mini_program.default'));

        $res = $app->app_code->get('/pages/product/product_info?id=1&push_user_id='.auth('weapp')->id(), []);

//        $filename = $res->saveAs(date('/Y/m/d',time()),time().random_int(100000,999999).'.png');

        $path = 'storage/'.date('Y/m/d',time());

        $filename = $res->saveAs($path,time().random_int(100000,999999).'.png');

        $product = Product::find($request->id);

        $store = Store::find($product->store_id);

        $data = [
            'url' => $product->thumb,
            'icon' => $store->logo,
            'title' => $product->name,
            'discountPrice' => $product->price,
            'orignPrice' => '',
            'code' => asset($path.'/'.$filename)
        ];

        return $this->success($data);

    }

}
