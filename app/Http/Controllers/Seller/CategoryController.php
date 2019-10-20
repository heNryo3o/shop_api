<?php

namespace App\Http\Controllers\Seller;

use App\Http\Requests\Seller\ChangeStatusRequest;
use App\Http\Requests\Seller\DestroyRequest;
use App\Http\Requests\Seller\CategoryRequest;
use App\Http\Resources\Seller\CategoryResource;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Overtrue\Pinyin\Pinyin;

class CategoryController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Category::filter($request->all())->with('admin:admins.id,admins.username')->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

        return $this->success(CategoryResource::collection($list));

    }

    public function create(CategoryRequest $request)
    {

        $data = $request->all();

        if($request->parent_id){

            $data['parent_id'] = is_array($data['parent_id']) ? Arr::last($request->parent_id) : $data['parent_id'];

            $parent = Category::where('id',$data['parent_id'])->get('level')->first();

            $data['level'] = $parent['level'] + 1;

        }else{

            $data['level'] = 1;

        }

        $data['parent_id'] = empty($data['parent_id']) ? null : $data['parent_id'];

        $data['pinyin'] = implode('',pinyin($data['name']));

        Category::create($data);

        return $this->success();

    }

    public function edit(CategoryRequest $request)
    {

        $data = $request->all();

        if($request->parent_id){

            $data['parent_id'] = is_array($data['parent_id']) ? Arr::last($request->parent_id) : $data['parent_id'];

            $parent = Category::where('id',$data['parent_id'])->get('level')->first();

            $data['level'] = $parent['level'] + 1;

        }else{

            $data['level'] = 1;

        }

        $data['parent_id'] = empty($data['parent_id']) ? null : $data['parent_id'];

        $category = Category::find($request->id);

        if($category->level !== $data['level']){

            return $this->failed('不可以修改分类等级');

        }

        $data['pinyin'] = implode('',pinyin($data['name']));

        Category::find($request->id)->update($data);

        return $this->success();

    }

    public function changeStatus(ChangeStatusRequest $request)
    {

        Category::find($request->id)->update(['status'=>$request->status]);

        return $this->success();

    }

    public function destroy(DestroyRequest $request)
    {

        Category::destroy($request->id);

        return $this->success();

    }


    public function options()
    {

        $data = [];

        $parent = Category::where(['level'=>1])->remember(10080)->get(['id','name'])->toArray();

        foreach ($parent as $k => $v){

            $data[$k] = $v;

            $child = Category::where(['parent_id'=>$v['id']])->remember(10080)->get(['id','name']);

            if($child){

                foreach ($child->toArray() as $vk => $vv){

                    $data[$k]['children'][$vk] = $vv;

                    $children = Category::where(['parent_id'=>$vv['id']])->remember(10080)->get(['id','name']);

                    if($children){

                        foreach ($children->toArray() as $vvk => $vvv){

                            $data[$k]['children'][$vk]['children'][$vvk] = $vvv;

                        }

                    }else{

                        $data[$k]['children'][$vk]['children'] = [];

                    }

                }

            }else{

                $data[$k]['children'] = [];

            }

        }

        $options = $this->dealOptions($data,'id','name');

        return $this->success($options);

    }

    public function subOptions()
    {

        $store_id = auth('seller')->id();

        $store = Store::find($store_id);

        $data = [];

        $parent = Category::where(['level'=>2,'parent_id'=>$store->is_online])->remember(10080)->get(['id','name'])->toArray();

        foreach ($parent as $k => $v){

            $data[$k] = $v;

            $child = Category::where(['parent_id'=>$v['id']])->remember(10080)->get(['id','name']);

            if($child){

                foreach ($child->toArray() as $vk => $vv){

                    $data[$k]['children'][$vk] = $vv;

                    $children = Category::where(['parent_id'=>$vv['id']])->remember(10080)->get(['id','name']);

                    if($children){

                        foreach ($children->toArray() as $vvk => $vvv){

                            $data[$k]['children'][$vk]['children'][$vvk] = $vvv;

                        }

                    }else{

                        $data[$k]['children'][$vk]['children'] = [];

                    }

                }

            }else{

                $data[$k]['children'] = [];

            }

        }

        $options = $this->dealOptions($data,'id','name');

        return $this->success($options);

    }

}
