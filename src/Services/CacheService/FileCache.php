<?php

namespace App\Services\CacheService;

class FileCache implements CacheInterface
{
    public function __construct(
        protected string $directory = '/tmp'
    ) {}
    public function get(string $key, ?int $expire, callable $callback): mixed
    {
        $key = sha1($key);
        $fileName = "{$key}_cache.dat";
        $path = "{$this->directory}/$fileName";

        if (is_file($fileName))
            return unserialize(file_get_contents($path));

        $value = $callback();
        file_put_contents($path, serialize($value));

        return $value;
    }

    public function getSleepWaitTime(): int
    {
        return 0;
    }

    public function setSleepWaitTime(int $sleepWaitTime): void
    {
        // TODO: Implement setSleepWaitTime() method.
    }

    public function setLockKeySuffix(string $lockKeySuffix): void
    {
        // TODO: Implement setLockKeySuffix() method.
    }
}