<?php

namespace Rynest\Zkteco\Console;

use Illuminate\Console\Command;
use Rynest\Zkteco\Models\ZktecoDevice;
use Rynest\Zkteco\Models\ZktecoUser;
use Rynest\Zkteco\Models\ZktecoAttendance;
use Rynest\Zkteco\ZkClient;

class SyncCommand extends Command
{
    protected $signature = 'zkteco:sync {device? : Device name or id} {--all}';
    protected $description = 'Sync users and attendance from ZKTeco devices';

    public function handle()
    {
        $devices = ZktecoDevice::query();
        if ($this->argument('device')) {
            $devices->where('id', $this->argument('device'))->orWhere('name', $this->argument('device'));
        }
        if (!$this->option('all')) {
            $devices->where('is_active', true);
        }

        foreach ($devices->get() as $device) {
            $this->syncDevice($device);
        }
        $this->info('Sync selesai');
        return 0;
    }

    protected function syncDevice(ZktecoDevice $device)
    {
        $this->info("Syncing {$device->name} {$device->ip}:{$device->port}");
        $client = new ZkClient($device->ip, $device->port, $device->timeout ?? 5);
        $client->connect();

        foreach ($client->getUsers() as $u) {
            ZktecoUser::updateOrCreate(
                ['device_id' => $device->id, 'uid' => $u['uid']],
                [
                    'user_id' => $u['user_id'],
                    'name' => $u['name'],
                    'card' => $u['card'],
                    'privilege' => $u['privilege'],
                ]
            );
        }

        foreach ($client->getAttendance() as $a) {
            ZktecoAttendance::create([
                'device_id' => $device->id,
                'uid' => $a['uid'],
                'timestamp' => $a['timestamp'],
                'state' => $a['state'],
                'punch' => $a['punch'],
            ]);
        }

        $device->update(['last_sync_at' => now()]);
        $this->info("Done {$device->name}");
        $client->disconnect();
    }
}
