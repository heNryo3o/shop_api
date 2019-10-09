<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {

        $list = Category::where(['parent_id'=>1,'status'=>1])->orderBy('id','desc')->get()->toArray();

        $data = [['id'=>0,'name'=>'热门']];

        foreach ($list as $k => $v){
            $data[] = ['id'=>$v['id'],'name'=>$v['name']];
        }

        return $this->success($data);

    }

}
