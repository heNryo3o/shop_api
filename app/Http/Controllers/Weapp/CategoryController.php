<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {

        $list = Category::where(['parent_id'=>$request->parent,'status'=>1])->orderBy('id','desc')->get()->toArray();

        $first = $request->parent == 1 ? '热门' : '全部';

        $data = [['id'=>0,'name'=>$first]];

        foreach ($list as $k => $v){
            $data[] = ['id'=>$v['id'],'name'=>$v['name']];
        }

        return $this->success($data);

    }

    public function sub(Request $request)
    {

        $list = Category::where(['parent_id'=>$request->category_id,'status'=>1])->orderBy('id','desc')->get();

        $data = [];

        foreach ($list as $k => $v){
            $data[] = ['id'=>$v['id'],'name'=>$v['name'],'thumb'=>$v['thumb']];
        }

        return $this->success($data);

    }

}
