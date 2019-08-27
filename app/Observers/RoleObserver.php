<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    public function saved(Role $model){

        $model->flushCache();

    }

    public function deleted(Role $model){

        $model->flushCache();

    }

    public function created(Role $model){

        $model->flushCache();

    }
}
