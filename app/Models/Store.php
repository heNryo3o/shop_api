<?php

namespace App\Models;

class Store extends PublicModel
{

    protected $rememberCacheTag = 'Store';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'username',
        'password',
        'status',
        'mobile',
        'licence',
        'id_card',
        'id_card_back',
        'category',
        'area',
        'address',
        'bank_card',
        'collect',
        'user_id',
        'logo',
        'thumb',
        'evalue',
        'is_online',
        'browse',
        'category_id',
        'sub_category_id',
        'shangquan',
        'rate',
        'average_cost',
        'money',
        'money_block',
        'money_total',
        'fuli',
        'open_time',
        'sold',
        'city'
    ];

    protected $casts = [
        'area'=>'json',
        'category' => 'json',
        'fuli' => 'json'
    ];

    protected $appends = [
        'product_num',
        'category_name',
        'area_name',
        'state'
    ];

    public function getProductNumAttribute()
    {
        return Product::where(['store_id'=>$this->id,'status'=>1])->count();
    }

    public function products()
    {
        return $this->hasMany(Store::class);
    }

    public function getCategoryNameAttribute()
    {

        $category = Category::whereIn('id',$this->category)->get()->toArray();

        $arr = array_column($category,'name');

        unset($arr[0]);

        return implode('/',$arr);

    }

    public function getAreaNameAttribute()
    {

        $area = Area::whereIn('id',$this->area)->get()->toArray();

        $arr = array_column($area,'name');

        return implode('/',$arr);

    }

    public function getStateAttribute()
    {

        if($this->status == 1){
            return '待审核';
        }elseif($this->status == 2){
            return '待完善信息';
        }elseif($this->status == 3){
            return '审核未通过';
        }elseif($this->status == 4){
            return '已完善信息';
        }elseif($this->status == 5){
            return '已下架';
        }

    }

}
