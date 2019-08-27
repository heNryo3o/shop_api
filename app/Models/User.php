<?php

namespace App\Models;

class User extends PublicModel
{

    protected $rememberCacheTag = 'User';

    // 用户类型
    const SELLER = 1;        // 解决方
    const BUYER = 2;         // 需求方

    // 会员等级
    const NORMAL = 1;        // 基础店
    const GOLD = 2;          // 黄金店
    const DIAMOND = 3;       // 钻石店
    const CROWN = 4;         // 皇冠店

    protected $appends = ['prefer_name','vip_name'];

    public function pushLogs()
    {
        return $this->hasMany(PushLog::class);
    }

    public function getPreferNameAttribute()
    {
        switch ($this->prefer){
            case self::SELLER:
                return '解决方';
            case self::BUYER:
                return '需求方';
            default:
                return '未确认';
        }
    }

    public function getVipNameAttribute()
    {
        switch ($this->vip_level){
            case self::NORMAL:
                return '基础店';
            case self::GOLD:
                return '黄金店';
            case self::DIAMOND:
                return '钻石店';
            case self::CROWN:
                return '皇冠店';
            default:
                return '普通会员';
        }
    }

}
