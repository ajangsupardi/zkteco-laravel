<?php

namespace Rynest\Zkteco;

use RuntimeException;

/**
 * ZkClient - TCP client for ZKTeco devices on port 4370
 */
class ZkClient
{
    protected $socket;
    protected string $ip;
    protected int $port;
    protected int $timeout;
    protected int $sessionId;
    protected int $replyId;

    public function __construct(string $ip, int $port = 4370, int $timeout = 5)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->timeout = $timeout;
        $this->sessionId = random_int(1, 999999);
        $this->replyId = 0;
    }

    public function connect(): void
    {
        $this->socket = @fsockopen($this->ip, $this->port, $errno, $errstr, $this->timeout);
        if (!$this->socket) {
            throw new RuntimeException("Could not connect to {$this->ip}:{$this->port} - $errstr");
        }
        stream_set_timeout($this->socket, $this->timeout);
        $this->sendCommand(Const::CMD_CONNECT, '');
    }

    public function disconnect(): void
    {
        if ($this->socket) {
            $this->sendCommand(Const::CMD_EXIT, '');
            fclose($this->socket);
            $this->socket = null;
        }
    }

    public function getUsers(): array
    {
        $data = $this->sendCommand(Const::CMD_USERTEMP_RRQ, pack('C', 1));
        if (strlen($data) < 4) return [];
        $totalSize = unpack('V', substr($data, 0, 4))[1];
        $payload = substr($data, 4);
        return $this->parseUsers($payload, $totalSize);
    }

    public function getAttendance(): array
    {
        $data = $this->sendCommand(Const::CMD_GET_ATTENDANCE, pack('C', 2));
        if (strlen($data) < 4) return [];
        $totalSize = unpack('V', substr($data, 0, 4))[1];
        $payload = substr($data, 4);
        return $this->parseAttendance($payload, $totalSize);
    }

    protected function sendCommand(int $command, string $payload): string
    {
        $header = pack('VVV', $this->sessionId, $command, strlen($payload));
        fwrite($this->socket, $header . $payload);
        $respHeader = fread($this->socket, 12);
        if (strlen($respHeader) < 12) {
            throw new RuntimeException('Invalid response header');
        }
        $unpacked = unpack('Vsession/Vcommand/Vlength', $respHeader);
        $length = $unpacked['length'];
        $data = '';
        while (strlen($data) < $length) {
            $chunk = fread($this->socket, $length - strlen($data));
            if ($chunk === false) break;
            $data .= $chunk;
        }
        return $data;
    }

    protected function parseUsers(string $data, int $size): array
    {
        $users = [];
        $offset = 0;
        while ($offset + 72 <= $size) {
            $chunk = substr($data, $offset, 72);
            $u = unpack('vuid/vprivilege/a8password/a24name/Vcard/a7group/a24userid', $chunk);
            $users[] = [
                'uid' => $u['uid'],
                'privilege' => $u['privilege'],
                'password' => rtrim($u['password'], "\0"),
                'name' => rtrim($u['name'], "\0"),
                'card' => $u['card'],
                'group_id' => rtrim($u['group'], "\0"),
                'user_id' => rtrim($u['userid'], "\0"),
            ];
            $offset += 72;
        }
        return $users;
    }

    protected function parseAttendance(string $data, int $size): array
    {
        $records = [];
        $offset = 0;
        while ($offset + 12 <= $size) {
            $chunk = substr($data, $offset, 12);
            $a = unpack('Vuid/Cstate/Cpunch/a6time', $chunk);
            $records[] = [
                'uid' => $a['uid'],
                'state' => $a['state'],
                'punch' => $a['punch'],
                'timestamp' => $this->decodeTime($a['time']),
            ];
            $offset += 12;
        }
        return $records;
    }

    protected function decodeTime(string $timehex): string
    {
        $bytes = unpack('C6', $timehex);
        $year = $bytes[1] + 2000;
        $month = $bytes[2];
        $day = $bytes[3];
        $hour = $bytes[4];
        $minute = $bytes[5];
        $second = $bytes[6] ?? 0;
        return sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hour, $minute, $second);
    }
}
