<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class SystemController extends Controller
{

    public function banners()
    {

        $list = Banner::where(['status'=>1,'type'=>1])->orderBy('id','desc')->limit(5)->get();

        $banner = Banner::where(['status'=>1,'type'=>2])->orderBy('id','desc')->first();

        return $this->success(['list'=>$list,'single'=>$banner]);

    }

}
