<?php

namespace Core;

class Configuration implements ConfigurationInterface {
    private readonly string $appRoot;
    private readonly string $sourceDir;
    private array $environment;

    public function __construct(string $appRoot, string $sourceDir) {
        $this->appRoot = $appRoot;
        $this->sourceDir = $sourceDir;
        $this->readEnvFile();
    }

    public function getSourceDir(): string {
        return $this->sourceDir;
    }

    public function getAppRoot(): string {
        return $this->appRoot;
    }

    public function getEnv(string $key, $default = null): string|array|null {
        return $this->environment[$key] ?? $default;
    }

    protected function readEnvFile(): void {
        $envFilePath = $this->appRoot . DIRECTORY_SEPARATOR . '.env';
        $this->environment = is_file($envFilePath) ? parse_ini_file($envFilePath) : [];
    }
}