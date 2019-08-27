<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;
use Watson\Rememberable\Rememberable;

class PublicModel extends Model
{

    use Filterable, Rememberable;

    protected $guarded = [];

    protected $hidden = ['pivot'];

}
