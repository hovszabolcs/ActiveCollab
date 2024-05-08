<?php

namespace Core;

class Session
{
    protected static $instance;

    protected const APP_KEY = 'app';
    protected const SESSION_NAME = 'sid';

    protected array $store = [];

    public static function getInstance(): static {
        if(!static::$instance)
            static::$instance = new static();

        return static::$instance;
    }

    private function __construct() {
        $this->start();
    }
    public function delete($key) {
        unset($_SESSION[static::APP_KEY][$key]);
    }
    public function clear(): void {
        session_unset();
    }
    public function start(): void {
        if ($this->isActive())
            return;
        session_name(static::SESSION_NAME);
        session_start();
    }
    public function closeForWrite(): void {
        session_write_close();
    }
    public function destroy(): void {
        if (!$this->isActive())
            return;

        session_destroy();
    }
    public function set(string $key, mixed $value): self {
        $_SESSION[static::APP_KEY][$key] = $value;
        return $this;
    }
    /** Fetch and remove **/
    public function pull(string $key) {
        if (array_key_exists($key, $this->store))
            return $this->store[$key];

        $value = $this->get($key);
        $this->store[$key] = $value;

        $this->delete($key);
        return $value;
    }
    public function has(string $key): bool {
        return array_key_exists($key, $_SESSION[static::APP_KEY] ?? []);
    }

    public function get(string $key, mixed $default = null): mixed {
        return $_SESSION[static::APP_KEY][$key] ?? $default;
    }

    protected function isActive() {
        return session_status() === PHP_SESSION_ACTIVE;
    }
}