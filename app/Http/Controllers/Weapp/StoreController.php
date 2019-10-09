<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Http\Resources\Weapp\ProductResource;
use App\Http\Resources\Weapp\StoreResource;
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

    public function index(Request $request)
    {

        $query = Store::where(['status'=>1,'is_online'=>2]);

        $query = $request->category_id > 0 ? $query->where('category_id',$request->category_id) : $query;

        $list = $query->orderBy('id','desc')->paginate(12);

        return $this->success(StoreResource::collection($list));

    }

    public function productList(Request $request)
    {

        $query = Product::where(['status'=>1,'store_id'=>$request->id]);

        if($request->order_type > 0){

            $sort_type = $request->order_type == 1 ? 'asc' : 'desc';

            if($request->order == 1){

                $query = $query->orderBy('sold',$sort_type)->orderBy('price',$sort_type);

            }elseif($request->order == 2){

                $query = $query->orderBy('sold',$sort_type);

            }elseif($request->order == 3){

                $query = $query->orderBy('price',$sort_type);

            }elseif($request->order == 4){

                $query = $query->orderBy('evalue',$sort_type);

            }

        }

        $list = $query->orderBy('id','desc')->get();

        return $this->success(ProductResource::collection($list));

    }

}