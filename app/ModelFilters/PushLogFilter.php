<?php

namespace App\ModelFilters;

class PushLogFilter extends PublicFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */

    public $relations = [];

    public function type($value)
    {
        return $this->where('type',$value);
    }

    public function result($value)
    {
        return $this->where('result',$value);
    }

    public function pushType($value)
    {
        return $this->where('push_type',$value);
    }

}
