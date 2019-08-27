<?php

namespace App\Observers;

use App\Models\Member;

class MemberObserver
{
    public function saved(Member $model){

        $model->flushCache();

    }

    public function deleted(Member $model){

        $model->flushCache();

    }

    public function created(Member $model){

        $model->flushCache();

    }
}
