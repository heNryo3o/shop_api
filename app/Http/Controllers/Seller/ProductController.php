<?php

namespace App\Http\Controllers\Seller;

use App\Http\Requests\Seller\ChangeStatusRequest;
use App\Http\Requests\Seller\DestroyRequest;
use App\Http\Requests\Seller\ProductRequest;
use App\Http\Requests\Seller\StoreRequest;
use App\Http\Resources\Admin\StoreResource;
use App\Http\Resources\Seller\ProductResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductSku;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JMessage\IM\User;
use JMessage\JMessage;

class ProductController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Product::filter($request->all())->where('store_id',auth('seller')->id())->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(ProductResource::collection($list));

    }

    public function create(ProductRequest $request)
    {

        $store = Store::find(auth('seller')->id());

        if($store->is_online == 2 && empty($request->attention)){
            return $this->failed('请填写注意事项');
        }

        $data = $request->all();

        $data['is_online'] = $store->is_online;

        $data['category_id'] = $data['category'][0];

        $data['sub_category_id'] = isset($data['category'][1]) ? $data['category'][1] : 0;

        $skus = $data['skus'];

        $data['price'] = 0;

        foreach ($skus as $k => $v){

            if(empty($v['title']) || empty($v['price']) || ($store->is_online == 1 && empty($v['stock']))){
                return $this->failed('请完善商品规格信息');
            }

            $data['price'] = $data['price'] > $v['price'] || $data['price'] == 0 ? $v['price'] : $data['price'];

        }

        $product = Product::create($data);

        foreach ($skus as $k => $v){

            $v['product_id'] = $product->id;

            ProductSku::create($v);

        }

        return $this->success();

    }

    public function edit(ProductRequest $request)
    {

        $store = Store::find(auth('seller')->id());

        if($store->is_online == 2 && empty($request->attention)){
            return $this->failed('请填写注意事项');
        }

        $product = Product::find($request->id);

        $data = $request->all();

        $data['category_id'] = $data['category'][0];

        $data['sub_category_id'] = isset($data['category'][1]) ? $data['category'][1] : 0;

        $skus = $data['skus'];

        $data['price'] = 0;

        $exist_skus = [];

        foreach ($skus as $k => $v){

            if(empty($v['title']) || empty($v['price']) || ($store->is_online == 1 && empty($v['stock']))){
                return $this->failed('请完善商品规格信息');
            }

            $exist_skus[] = $v['id'];

            $data['price'] = $data['price'] > $v['price'] || $data['price'] == 0 ? $v['price'] : $data['price'];

        }

        $deleted = ProductSku::where('product_id',$request->id)->whereNotIn('id',$exist_skus)->get()->toArray();

        if($deleted){

            foreach ($deleted as $k => $v){

                CartItem::where('product_sku_id',$v['id'])->delete();

            }

            ProductSku::where('product_id',$request->id)->whereNotIn('id',$exist_skus)->delete();

        }

        foreach ($skus as $k => $v){

            $v['product_id'] = $request->id;

            if($v['id'] == 0){

                ProductSku::create($v);

            }else{

                ProductSku::find($v['id'])->update($v);

            }

        }

        $product->update($data);

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        Product::find($request->id)->update(['status'=>$request->status]);

        return $this->success();

    }

}
