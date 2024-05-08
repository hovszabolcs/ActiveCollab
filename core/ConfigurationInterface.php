<?php

namespace Core;

interface ConfigurationInterface {
    public function getSourceDir(): string;
    public function getAppRoot(): string;
    public function getEnv(string $key, $default = null): string|array|null;
}