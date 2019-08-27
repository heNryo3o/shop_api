<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PushResource extends JsonResource
{

    public function toArray($request)
    {

        $we_chat_default = [
            'first' => '',
            'kw1' => '',
            'kw2' => '',
            'kw3' => '',
            'kw4' => '',
            'remark' => '',
            'template_id' => '',
            'url' => ''
        ];

        return [
            'id' => $this->id,
            'type' => $this->type,
            'param' => $this->param,
            'type_we_chat' => $this->type_we_chat,
            'type_app_buyer' => $this->type_app_buyer,
            'type_sms' => $this->type_sms,
            'type_app_seller' => $this->type_app_seller,
            'status' => $this->status,
            'describe' => $this->describe,
            'module' => $this->module,
            'inside' => $this->inside,
            'accept_admins' => $this->accept_admins,
            'push_type' => $this->push_type,
            'created_at' => $this->created_at->toDateTimeString(),
            'we_chat_template' => $this->we_chat_template ? $this->we_chat_template : $we_chat_default,
            'app_buyer_template' => $this->app_buyer_template ? $this->app_buyer_template : ['content' => ''],
            'app_seller_template' => $this->app_seller_template ? $this->app_seller_template : ['content' => ''],
            'sms_template' => $this->sms_template ? $this->sms_template : ['content' => '', 'template_id' => ''],
        ];

    }

}
