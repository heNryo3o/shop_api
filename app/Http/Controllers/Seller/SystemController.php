<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JMessage\IM\Report;
use JMessage\JMessage;

class SystemController extends Controller
{

    public function upload(Request $request)
    {

        $save = 'public/'.date('Y/m/d', time());

        $path = $request->file('file')->store($save);

        $url = Storage::url($path);

        $full_url = config('filesystems.default') == 'oss' ? config('filesystems.oss_url').$path : asset($url);

        $from_editor = $request->input('from_editor', '2');

        $log = [
            'file_url' => $path,
            'full_url' => asset($url),
            'from_editor' => $from_editor,
            'admin_id' => auth('admin')->id(),
            'ip' => $request->getClientIp()
        ];

        $model = Upload::create($log);

        $result = array(
            'preview_url' => $full_url,
            'file_url' => $path,
            'file_id' => $model->id
        );

        return $this->success($result);

    }

}
