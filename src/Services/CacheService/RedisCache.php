<?php
namespace App\Services\CacheService;

use Predis\Client;

class RedisCache implements CacheInterface
{
    private int $sleepWaitTime = 100;
    private string $lockKeySuffix = '_lock';

    private Client $client;

    public function __construct(string $url) {
        $client = new Client($url);
        $this->client = $client;
    }

    public function get(string $key, ?int $expire, callable $callback): mixed {
        $client = $this->client;
        $lockKey = "{$key}{$this->lockKeySuffix}";

        if ($client->exists($key))
            return unserialize($client->get($key));

        if ($client->setnx($lockKey, true)) {
            $value = $callback();
            $serializedValue = serialize($value);
            $expire === null ? $client->set($key, $serializedValue) : $client->setex($key, $expire, $serializedValue);
            $client->del($lockKey);
            return $value;
        }
        else {
            while ($client->exists($lockKey)) {
                usleep($this->sleepWaitTime);
            }
            return $this->get($key, $expire, $callback);
        }
    }
    public function getSleepWaitTime(): int {
        return $this->sleepWaitTime;
    }
    public function setSleepWaitTime(int $sleepWaitTime): void {
        $this->sleepWaitTime = $sleepWaitTime;
    }
    public function setLockKeySuffix(string $lockKeySuffix): void {
        $this->lockKeySuffix = $lockKeySuffix;
    }
}