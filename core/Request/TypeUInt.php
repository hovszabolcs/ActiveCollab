<?php

namespace Core\Request;

class TypeUInt extends TypeString
{
    public static string $errIsNotAnUnsignedInteger = 'Is not an unsigned integer';

    public function typeCheck($value): bool
    {
        // is_numeric accepts 20.323E+2
        return parent::typeCheck($value) && is_numeric($value) && preg_match('/^\d{,10}$/', $value);
    }

    public function check($value): void
    {
        parent::check($value);

        if(!is_numeric($value) || !preg_match('/^\d{,10}$/', $value))
            throw new TypeCheckErrorException(static::$errIsNotAnUnsignedInteger);
    }
}