<?php

namespace Rynest\Zkteco\Models;

use Illuminate\Database\Eloquent\Model;

class ZktecoUser extends Model
{
    protected $table = 'zkteco_users';
    protected $fillable = ['device_id','uid','user_id','name','card','privilege'];
}
