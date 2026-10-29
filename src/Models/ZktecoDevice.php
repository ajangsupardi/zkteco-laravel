<?php

namespace Rynest\Zkteco\Models;

use Illuminate\Database\Eloquent\Model;

class ZktecoDevice extends Model
{
    protected $table = 'zkteco_devices';
    protected $fillable = ['name','ip','port','serial','timeout','is_active'];

    public function users()
    {
        return $this->hasMany(ZktecoUser::class,'device_id');
    }

    public function attendance()
    {
        return $this->hasMany(ZktecoAttendance::class,'device_id');
    }
}
