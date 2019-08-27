<?php

namespace App\Models;

class Category extends PublicModel
{

    protected $rememberCacheTag = 'Category';

    protected $appends = ['type_name'];

    public function getTypeNameAttribute()
    {

        switch ($this->type){
            case 'news':
                return '新闻';
            case 'help':
                return '帮助文章';
            default:
                return '分类';
        }

    }

}
