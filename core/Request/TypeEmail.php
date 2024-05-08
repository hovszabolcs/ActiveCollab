<?php

namespace Core\Request;

class TypeEmail extends TypeString
{
    public static string $errIsNotEmail = 'This is not an email';
    public function check($value): void
    {
        parent::check($value);

        // RFC-822
        if(!preg_match('#^[a-z0-9!\#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!\#$%&\'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$#', $value))
            throw new TypeCheckErrorException(static::$errIsNotEmail);
    }
}