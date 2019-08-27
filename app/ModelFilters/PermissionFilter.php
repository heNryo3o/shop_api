<?php

namespace App\ModelFilters;

class PermissionFilter extends PublicFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */

    public $relations = ['roles' => ['role_id']];

    public function name($value)
    {
        return $this->whereLike('name', $value);
    }

    public function parent($value)
    {
        return $this->where('parent_id', $value);
    }

}
