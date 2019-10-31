<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductSku;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Product::filter($request->all())->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(ProductResource::collection($list));

    }

    public function edit(ProductRequest $request)
    {

        if($request->is_online == 2 && empty($request->attention)){
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

            if(empty($v['title']) || empty($v['price']) || ($request->is_online == 1 && empty($v['stock']))){
                return $this->failed('请完善商品规格信息');
            }

            if(!is_numeric($v['price'])){
                return $this->failed('商品价格必须是整数或小数');
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

    public function setDapai(ChangeStatusRequest $request)
    {

        Product::find($request->id)->update(['is_dapai'=>$request->status]);

        return $this->success();

    }

}
