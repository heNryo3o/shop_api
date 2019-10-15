<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Http\Resources\Weapp\ProductResource;
use App\Models\CartItem;
use App\Models\Collect;
use App\Models\Evalue;
use App\Models\Product;
use App\Models\ProductSku;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {

        $query = Product::where(['status' => 1]);

        $query = $request->category_id > 0 ? $query->where('category_id', $request->category_id) : $query;

        $query = $request->sub_category_id > 0 ? $query->where('sub_category_id', $request->sub_category_id) : $query;

        if ($request->order_type > 0) {

            $sort_type = $request->order_type == 1 ? 'asc' : 'desc';

            if ($request->order == 1) {

                $query = $query->orderBy('sold', $sort_type)->orderBy('price', $sort_type);

            } elseif ($request->order == 2) {

                $query = $query->orderBy('sold', $sort_type);

            } elseif ($request->order == 3) {

                $query = $query->orderBy('price', $sort_type);

            } elseif ($request->order == 4) {

                $query = $query->orderBy('evalue', $sort_type);

            }

        }

        $list = $query->orderBy('id', 'desc')->paginate(12);

        return $this->success(ProductResource::collection($list));

    }

    public function dapai(Request $request)
    {

        $list = Product::where(['status' => 1, 'is_dapai' => 1])->orderBy('id', 'desc')->paginate(10);

        return $this->success(ProductResource::collection($list));

    }

    public function info(Request $request)
    {

        $product = Product::find($request->id)->toArray();

        $product['is_collect'] = Collect::where(['type' => 1, 'user_id' => auth('weapp')->id(), 'item_id' => $product['id']])->count() > 0 ? 1 : 0;

        $evalue = Evalue::where(['product_id' => $product['id']])->orderBy('id', 'desc')->first();

        if ($evalue) {

            $evalue_user = User::find($evalue->user_id);

            $product['evalue'] = $evalue->toArray();

            $product['evalue']['avatar'] = $evalue_user->avatar;

            $product['evalue']['nickname'] = $evalue_user->nickname;

        } else {

            $product['evalue'] = ['id' => 0];

        }

        $store = Store::find($product['store_id']);

        $product['store_id'] = $store->id;

        $product['store_name'] = $store->name;

        $product['store_collect'] = $store->collect;

        $product['store_product_num'] = $store->product_num;

        $product['store_logo'] = $store->logo;

        $product['skus'] = ProductSku::where('product_id', $product['id'])->get()->toArray();

        return $this->success($product);

    }

    public function evalueList(Request $request)
    {

        $condition = $request->product_id > 0 ? ['product_id' => $request->product_id] : ['store_id' => $request->store_id];

        $list = Evalue::where($condition)->orderBy('id', 'desc')->get();

        $result = [];

        if ($list) {

            foreach ($list->toArray() as $k => $v) {

                $user = User::find($v['user_id']);

                $v['avatar'] = $user->avatar;

                $v['nickname'] = $user->nickname;

                $v['date'] = date('Y-m-d', strtotime($v['created_at']));

                $v['attach_urls'] = $v['attaches'] ? array_column($v['attaches'], 'url') : [];

                $result[] = $v;

            }

        }

        return $this->success(['list' => $result]);

    }

    public function collect(Request $request)
    {

        if ($request->status === 1) {

            $data = [
                'item_id' => $request->id,
                'type' => 1,
                'user_id' => auth('weapp')->id()
            ];

            if (Collect::where($data)->count() === 0) {
                Collect::create($data);
                Product::find($request->id)->increment('collect');
            }

        } else {

            $data = [
                'item_id' => $request->id,
                'type' => 1,
                'user_id' => auth('weapp')->id()
            ];

            if (Collect::where($data)->count() > 0) {
                Collect::where($data)->delete();
                Product::find($request->id)->decrement('collect');
            }

        }

        return $this->success();

    }

    public function addCart(Request $request)
    {

        $data = $request->all();

        $data['user_id'] = auth('weapp')->id();

        $sku = ProductSku::find($request->product_sku_id);

        if ($sku->stock < $request->amount) {
            return $this->failed('选购数量超出库存，请重新选择');
        }

        $exist = CartItem::where(['product_sku_id'=>$request->product_sku_id,'user_id'=>$data['user_id']])->first();

        if($exist){

            CartItem::find($exist->id)->update(['amount'=>($exist->amount+$data['amount'])]);

        }else{

            CartItem::create($data);

        }

        return $this->success();

    }

    public function cartChangeNumber(Request $request)
    {

        CartItem::find($request->cart_item_id)->update(['amount'=>$request->amount]);

        return $this->success();

    }

    public function cartList()
    {

        $data = [];

        $user_id = auth('weapp')->id();

        $list = CartItem::where('user_id', $user_id)->get();

        if ($list) {

            foreach ($list->toArray() as $k => $v) {

                $product = Product::find($v['product_id']);

                $sku = ProductSku::find($v['product_sku_id']);

                if (isset($data[$v['store_id']])) {

                    $data[$v['store_id']]['items'][] =
                        [
                            'checked' => false,
                            'item_id' => $v['id'],
                            'goodsName' => $product->name,
                            'goodsId' => $product->id,
                            'price' => $sku->price,
                            'sku_title' => $sku->title,
                            'img' => $product->thumb,
                            'count' => $v['amount']
                        ];

                } else {

                    $data[$v['store_id']] =
                        [
                            'checked' => false,
                            'shopId' => $v['store_id'],
                            'shopName' => Store::find($v['store_id'])->name,
                            'items' => [
                                [
                                    'checked' => false,
                                    'item_id' => $v['id'],
                                    'goodsName' => $product->name,
                                    'goodsId' => $product->id,
                                    'price' => $sku->price,
                                    'img' => $product->thumb,
                                    'sku_title' => $sku->title,
                                    'count' => $v['amount']
                                ]
                            ]
                        ];
                }

            }

        }

        return $this->success(['list'=>array_values($data)]);

    }

    public function delCart(Request $request)
    {

        CartItem::find($request->cart_item_id)->delete();

        return $this->success();

    }

}
