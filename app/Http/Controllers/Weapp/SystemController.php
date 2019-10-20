<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Setting;
use Illuminate\Http\Request;
use JMessage\IM\Report;
use JMessage\JMessage;

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

}
