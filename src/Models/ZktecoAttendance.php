<?php

namespace Rynest\Zkteco\Models;

use Illuminate\Database\Eloquent\Model;

class ZktecoAttendance extends Model
{
    protected $table = 'zkteco_attendance';
    protected $fillable = ['device_id','uid','timestamp','state','punch'];
}
