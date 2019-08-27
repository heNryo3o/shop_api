<?php

namespace App\Observers;

use App\Models\Upload;

class UploadObserver
{

    public function saved(Upload $model)
    {

        $model->flushCache();

    }

    public function deleted(Upload $model)
    {

        $model->flushCache();

    }

    public function created(Upload $model)
    {

        $model->flushCache();

    }

}
