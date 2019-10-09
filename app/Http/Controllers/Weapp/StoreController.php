<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Http\Resources\Weapp\ProductResource;
use App\Models\Collect;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{

    public function info(Request $request)
    {

        $store = Store::find($request->id)->toArray();

        $store['is_collect'] = Collect::where(['type'=>2,'user_id'=>auth('weapp')->id(),'item_id'=>$store['id']])->count() > 0 ? 1 : 0;

        return $this->success($store);

    }

    public function collect(Request $request)
    {

        if ($request->status === 1) {

            $data = [
                'item_id' => $request->id,
                'type' => 2,
                'user_id' => auth('weapp')->id()
            ];

            if(Collect::where($data)->count() === 0){
                Collect::create($data);
                Store::find($request->id)->increment('collect');
            }

        } else {

            $data = [
                'item_id' => $request->id,
                'type' => 2,
                'user_id' => auth('weapp')->id()
            ];

            if(Collect::where($data)->count() > 0){
                Collect::where($data)->delete();
                Store::find($request->id)->decrement('collect');
            }

        }

        return $this->success();

    }

    public function productList(Request $request)
    {

        $list = Product::where(['status'=>1,'store_id'=>$request->id])->orderBy('id','desc')->get();

        return $this->success(ProductResource::collection($list));

    }

}
