<?php

namespace App\Observers;

use App\Models\Push;

class PushObserver
{
    public function saved(Push $model){

        $model->flushCache();

    }

    public function deleted(Push $model){

        $model->flushCache();

    }

    public function created(Push $model){

        $model->flushCache();

    }
}
