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

    public function nickname($value)
    {
        return $this->whereLike('nickname',$value);
    }

    public function mobile($value)
    {
        return $this->whereLike('mobile',$value);
    }

    public function isPusher($value)
    {
        return $this->where('is_pusher',$value);
    }
}
