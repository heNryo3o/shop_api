<?php

namespace App\Observers;

use App\Models\Store;

class StoreObserver
{
    public function saved(Store $model){

        $model->flushCache();

    }

    public function deleted(Store $model){

        $model->flushCache();

    }

    public function created(Store $model){

        $model->flushCache();

    }
}
