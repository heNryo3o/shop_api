<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class PublicFilter extends ModelFilter
{

    /**
     * 这里放一些共用的筛选条件
     * @param $value
     * @return PublicFilter
     */

    public function status($value)
    {
        return $this->where('status', $value);
    }

    public function dateRange($value)
    {
        $start = date('Y-m-d H:i:s', strtotime($value['0']));

        $end = date('Y-m-d H:i:s', strtotime($value['1']) + 86400);

        return $this->whereBetween('created_at',[$start,$end]);

    }

    public function mobile($value)
    {
        return $this->related('user', 'mobile', 'like', '%'.$value.'%');
    }

    public function nickname($value)
    {
        return $this->related('user', 'nickname', 'like', '%'.$value.'%');
    }

}
