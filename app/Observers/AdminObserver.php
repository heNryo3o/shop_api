<?php

namespace App\Observers;

use App\Models\Admin;

class AdminObserver
{
    public function saved(Admin $model){

        $model->flushCache();

    }

    public function deleted(Admin $model){

        $model->flushCache();

    }

    public function created(Admin $model){

        $model->flushCache();

    }
}
