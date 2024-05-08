<?php

namespace Core\Request;

class TypeString extends BaseType implements TypeCheckerInterface
{
    // first level check
    public function typeCheck($value): bool
    {
        return is_string($value);
    }

    // full check for validation
    public function check($value): void
    {
        if(!$this->typeCheck($value))
            throw new TypeCheckErrorException(static::$errTypeMismatch);

        if($this->required && $this->isEmpty($value))
            throw new TypeCheckErrorException(static::$errRequired);
    }

    public function isEmpty(mixed $value): bool
    {
        return trim($value) === '';
    }

    public function sanitize(mixed $value): mixed
    {
        return trim($value);
    }
}