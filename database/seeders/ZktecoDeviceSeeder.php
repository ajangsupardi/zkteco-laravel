<?php

namespace Rynest\Zkteco\Database\Seeders;

use Illuminate\Database\Seeder;
use Rynest\Zkteco\Models\ZktecoDevice;

class ZktecoDeviceSeeder extends Seeder
{
    public function run(): void
    {
        ZktecoDevice::updateOrCreate(
            ['name' => 'main_gate'],
            ['ip' => '192.168.1.8', 'port' => 4370, 'timeout' => 5, 'is_active' => true]
        );
    }
}
