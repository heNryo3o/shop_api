<?php

namespace App\ModelFilters;

class UserLogFilter extends PublicFilter
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

}
