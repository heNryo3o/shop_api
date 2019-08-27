<?php

namespace App\Observers;

use App\Models\Permission;

class PermissionObserver
{
    public function saved(Permission $permission){

        $permission->flushCache();

    }

    public function deleted(Permission $permission){

        $permission->flushCache();

    }

    public function created(Permission $permission){

        $permission->flushCache();

    }
}
