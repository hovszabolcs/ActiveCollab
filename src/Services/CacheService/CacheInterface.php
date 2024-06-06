<?php

namespace App\Services\CacheService;

interface CacheInterface
{
    public function get(string $key, ?int $expire, callable $callback): mixed;
    public function getSleepWaitTime(): int;
    public function setSleepWaitTime(int $sleepWaitTime): void;
    public function setLockKeySuffix(string $lockKeySuffix): void;
}