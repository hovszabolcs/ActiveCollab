<?php

namespace Core\Request;

abstract class BaseType
{
    public static string $errTypeMismatch = 'Type mismatch';
    public static string $errRequired = 'Field is required';

    protected bool $required = false;
    public function Required(): static {
        $this->required = true;
        return $this;
    }

    abstract public function typeCheck($value): bool;
    abstract public function check(mixed $value): void;

    abstract protected function isEmpty(mixed $value): bool;
}