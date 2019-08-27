<?php

namespace App\Helpers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 统一管理接口的返回格式
 * Trait ApiResponse
 * @package App\Helpers
 */
trait ApiResponse
{

    /**
     * 返回响应的json数据给控制器
     * @param $data
     * @return mixed
     */

    public function respond(array $data)
    {

        return response()->json($data, 200);

    }

    public function joint(int $code, string $msg, $data = [])
    {

        $response = [
            'msg' => $msg,
            'code' => $code,
            'data' => (object)$data
        ];

        return $this->respond($response);

    }

    public function failed(string $msg, int $code = 5001)
    {

        return $this->joint($code, $msg);

    }

    /**
     * 成功时调用的响应方法
     * @param $data
     * @param string $msg
     * @return mixed
     */

    public function success($data = [], string $msg = '接口调用成功')
    {

        // 如果是用resource转换的列表,处理分页信息,自带的格式多余数据太多

        if ($data instanceof JsonResource && $data->resource instanceof LengthAwarePaginator) {

            $response = [];

            $resource = $data->resource;

            $response['list'] = $resource->items();

            $response['total'] = $resource->total();

            $response['has_more'] = $resource->lastPage() > $resource->currentPage() ? 1 : 0;

            return $this->joint(200, $msg, $response);

        }

        return $this->joint(200, $msg, $data);

    }

}
