<?php

namespace App\Models;

class DepositSetting extends PublicModel
{

    protected $rememberCacheTag = 'DepositSetting';

    protected $fillable = [
        'created_at',
        'updated_at',
        'deposit_money',
        'give_money'
    ];

    protected $appends = [
        'deposit',
        'give'
    ];

    public function getDepositAttribute()
    {
        return floatval($this->deposit_money);
    }

    public function getGiveAttribute()
    {
        return floatval($this->give_money);
    }

}
