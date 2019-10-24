<?php

namespace App\Models;

use EasyWeChat\Factory;
use Illuminate\Support\Facades\Storage;

class User extends PublicModel
{

    protected $fillable = [
        'nickname',
        'open_id',
        'status',
        'created_at',
        'updated_at',
        'avatar',
        'remain_money',
        'money',
        'money_block',
        'is_pusher',
        'parent_user_id',
        'mobile'
    ];

    protected $rememberCacheTag = 'User';

    protected $appends = ['invite_src'];

    public function pushLogs()
    {
        return $this->hasMany(PushLog::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getInviteSrcAttribute()
    {

        $file = 'storage/invite/'.$this->id.'.png';

        if(!Storage::exists($file)){

            $this->generateInviteCode($this->id);

        }

        return asset($file);

    }

    public function generateInviteCode($user_id)
    {

        $app = Factory::miniProgram(config('wechat.mini_program.default'));

        $res = $app->app_code->get('/pages/home/home?push_user_id='.auth('weapp')->id(), []);

        $path = 'storage/invite';

        $res->saveAs($path,$user_id.'.png');

        return;

    }

}
