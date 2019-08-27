<?php

namespace App\ModelFilters;

use App\Models\Push;

class PushFilter extends PublicFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */

    public $relations = [];

    public function module($value)
    {
        return $this->where('module',$value);
    }

    public function describe($value)
    {
        return $this->whereLike('describe',$value);
    }

    public function pushType($value)
    {
        $type_map = (new Push())->type_map;

        foreach ($type_map as $k => $v){
            if($k == $value){
                return $this->where([$v=>1]);
            }
        }

        return $this;

    }

}
