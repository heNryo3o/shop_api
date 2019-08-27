<?php

namespace App\Models;

class PushLog extends PublicModel
{

    protected $fillable = [
        'type',
        'push_type',
        'uid',
        'created_at',
        'updated_at',
        'result',
        'error',
        'param',
        'viewed',
        'mobile'
    ];

    protected $casts = [
        'param' => 'json'
    ];

    protected $appends = ['param_content'];

    public function getParamContentAttribute()
    {

        $param_content = [];

        foreach ($this->param as $vk => $vv) {

            $param_content[] = ['key' => $vk, 'value' => $vv];

        }

        return $param_content;

    }

}
