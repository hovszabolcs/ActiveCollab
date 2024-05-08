<?php

namespace Core;

abstract class View implements Renderable
{
    // Sometimes need access view params before make view instance - eg.: global messages
    protected static array $params = [];

    public static function getParam(string $key, mixed $default = null): mixed {
        return static::$params[$key] ?? $default;
    }

    public static function setParam(string $key, mixed $value): void {
        static::$params[$key] = $value;
    }

    public static function getParams(): array {
        return static::$params;
    }

    public static function setParams(array $params): void {
        static::$params = $params;
    }
}