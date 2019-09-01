<?php

namespace App\Observers;

use App\Models\Product;

class ServiceObserver
{
    public function saved(Product $model){

        $model->flushCache();

    }

    public function deleted(Product $model){

        $model->flushCache();

    }

    public function created(Product $model){

        $model->flushCache();

    }
}
