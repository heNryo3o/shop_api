<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function saved(Category $model){

        $model->flushCache();

    }

    public function deleted(Category $model){

        $model->flushCache();

    }

    public function created(Category $model){

        $model->flushCache();

    }
}
