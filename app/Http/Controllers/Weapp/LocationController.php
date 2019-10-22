<?php

namespace App\Http\Controllers\Weapp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Weapp\LocationRequest;
use App\Http\Resources\Weapp\LocationResource;
use App\Models\Location;
use App\Models\Order;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    public function default(Request $request)
    {

        if($request->location_id > 0){

            $location = Location::find($request->location_id);

            Order::find($request->order_id)->update(
                [
                    'address' => $location->address,
                    'mobile' => $location->mobile,
                    'linkman' => $location->linkman,
                    'location_id' => $request->location_id
                ]
            );

        }else{

            $location = Location::where(['user_id'=>auth('weapp')->id(),'is_default'=>1])->get()->first();

            Order::find($request->order_id)->update(
                [
                    'address' => $location->address,
                    'mobile' => $location->mobile,
                    'linkman' => $location->linkman,
                    'location_id' => $request->location_id
                ]
            );

        }

        return $location ? $this->success(new LocationResource($location)) : $this->success();

    }

    public function create(LocationRequest $request)
    {

        $data = $request->all();

        $count = Location::where('user_id',auth('weapp')->id())->count();

        $data['is_default'] = $count == 0 ? 1 : 2;

        Location::create($data);

        return $this->success();

    }

    public function index(Request $request)
    {

        $query = Location::where(['user_id' => auth('weapp')->id()]);

        $order = $query->orderBy('id','desc')->paginate(100);

        return $this->success(LocationResource::collection($order));

    }

    public function edit(LocationRequest $request)
    {

        $location = Location::find($request->id);

        if($location->user_id != auth('weapp')->id()){
            return $this->failed('只能操作自己的地址');
        }

        $location->update($request->all());

        return $this->success();

    }

    public function delete(LocationRequest $request)
    {

        $location = Location::find($request->id);

        if($location->user_id != auth('weapp')->id()){
            return $this->failed('只能操作自己的地址');
        }

        $location->delete();

        return $this->success();

    }

    public function info(Request $request)
    {

        $location = Location::find($request->id);

        return $this->success(new LocationResource($location));

    }

}
