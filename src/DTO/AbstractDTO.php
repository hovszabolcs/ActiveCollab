<?php

namespace App\DTO;

use ReflectionClass;
use ReflectionProperty;

abstract class AbstractDTO
{
    private static array $objectVars;

    private static function refreshObjectVars($that): void {
        // This works with get_object_vars only when leave type signatures
        $reflect = new ReflectionClass($that);
        $props = array_column($reflect->getProperties(ReflectionProperty::IS_PUBLIC), 'name');

        self::$objectVars = array_merge(array_combine($props, $props), get_object_vars($that));
    }

    protected function getObjectVars(): array {
        if(!isset(static::$objectVars))
            static::refreshObjectVars($this);

        return static::$objectVars;
    }

    public static function fromArray(array $items): array {
        $list = [];
        foreach ($items as $item) {
            $list[] = new static($item);
        }
        return $list;
    }

    public function __construct(array $data) {
        $fields = $this->getObjectVars();

        foreach ($fields as $key => $sourceKey) {
            $transformMethod = 'transform' . ucfirst($key);
            $value = $data[$sourceKey] ?? null;

            if (method_exists($this, $transformMethod))
                $value = $this->{$transformMethod}($value);

            $this->{$key} = $value;
        }
    }
}