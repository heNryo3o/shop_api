<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function saved(User $model){

        $model->flushCache();

    }

    public function deleted(User $model){

        $model->flushCache();

    }

    public function created(User $model){

        $model->flushCache();

    }
}
