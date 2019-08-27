<?php

namespace App\ModelFilters;

class AdminFilter extends PublicFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */

    public $relations = ['roles' => ['role_id']];

    public function username($value)
    {
        return $this->whereLike('username', $value);
    }

    public function department($value)
    {
        return $this->where('department', $value);
    }

}
