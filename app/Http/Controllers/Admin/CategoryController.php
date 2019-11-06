<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ChangeStatusRequest;
use App\Http\Requests\Admin\DestroyRequest;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class CategoryController extends Controller
{

    public function index(Request $request)
    {

        $order_column = $request->input('order_column', 'id');

        $order_type = $request->input('order_type', 'desc');

        $list = Category::filter($request->all())->with('admin:admins.id,admins.true_name')->remember(10080)->orderBy($order_column, $order_type)->paginate($request->limit);

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


    public function parentOptions(Request $request)
    {

        $data = [];

        if($request->is_online == 1 || $request->is_online == 2){

            $parent = Category::where(['level'=>1,'id'=>$request->is_online])->remember(10080)->get(['id','name'])->toArray();

        }else{

            $parent = Category::where(['level'=>1])->remember(10080)->get(['id','name'])->toArray();

        }

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

    public function subOptions(Request $request)
    {

        $data = [];

        $parent = Category::where(['level'=>2,'parent_id'=>$request->is_online])->remember(10080)->get(['id','name'])->toArray();

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
