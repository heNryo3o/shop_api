<?php

namespace App\ModelFilters;

class UserFilter extends PublicFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */

    public $relations = [];

    public function mobile($value)
    {
        return $this->whereLike('mobile',$value);
    }

    public function prefer($value)
    {
        return $this->where('prefer',$value);
    }

    public function vipLevel($value)
    {
        return $this->where('vip_level',$value);
    }

}
