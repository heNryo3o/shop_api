<?php

namespace App\Exceptions;

use App\Helpers\ExceptionReport;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{

    public function render($request, Exception $exception)
    {
        // 将方法拦截到自己的ExceptionReport
        $reporter = ExceptionReport::make($exception);

        if ($reporter->shouldReturn()) {
            return $reporter->report();
        }

        if (config('app.debug')) {
            //开发环境，则显示详细错误信息
            return parent::render($request, $exception);
        } else {
            //线上环境,未知错误，则显示500
            return $reporter->prodReport();
        }

    }

}
