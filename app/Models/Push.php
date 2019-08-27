<?php

namespace App\Models;

class Push extends PublicModel
{

    protected $fillable = [
        'type',
        'param',
        'type_we_chat',
        'type_app_buyer',
        'type_sms',
        'status',
        'describe',
        'we_chat_template',
        'app_buyer_template',
        'sms_template',
        'module',
        'created_at',
        'updated_at',
        'type_app_seller',
        'app_seller_template',
        'accept_admins',
        'inside'
    ];

    protected $casts = [
        'we_chat_template' => 'json',
        'sms_template' => 'json',
        'app_buyer_template' => 'json',
        'app_seller_template' => 'json',
        'accept_admins' => 'json',
    ];

    protected $rememberCacheTag = 'Push';

    protected $appends = ['push_type'];

    public $type_map = [
        '1' => 'type_app_buyer',
        '2' => 'type_app_seller',
        '3' => 'type_we_chat',
        '4' => 'type_sms'
    ];

    public function getPushTypeAttribute()
    {

        $push_type = [];

        foreach ($this->type_map as $k => $v) {
            if ($this->$v == 1) {
                $push_type[] = $k.'';
            }
        }

        return $push_type;

    }

    public function dealPushType($data)
    {

        foreach ($this->type_map as $k => $v){

            if(in_array($k,$data['push_type'])){
                $data[$v] = 1;
            }else{
                $data[$v] = 0;
            }

        }

        return $data;

    }

}
