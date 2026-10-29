<?php

namespace Rynest\Zkteco;

class ZktecoService
{
    protected array $config;
    protected ?ZkClient $client = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function connect(string $ip, int $port = 4370): array
    {
        $this->client = new ZkClient($ip, $port, $this->config['default_timeout'] ?? 5);
        $this->client->connect();
        return ['ip' => $ip, 'port' => $port, 'status' => 'connected'];
    }

    public function getUsers(): array
    {
        $this->ensureConnected();
        return $this->client->getUsers();
    }

    public function getAttendance(): array
    {
        $this->ensureConnected();
        return $this->client->getAttendance();
    }

    public function disconnect(): void
    {
        $this->client?->disconnect();
        $this->client = null;
    }

    protected function ensureConnected(): void
    {
        if (!$this->client) {
            throw new \RuntimeException('Not connected');
        }
    }
}
