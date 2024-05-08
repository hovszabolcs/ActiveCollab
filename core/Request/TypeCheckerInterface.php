<?php

namespace Core\Request;

interface TypeCheckerInterface
{
    public function check(mixed $value): void;
    public function typeCheck($value): bool;
    public function sanitize(mixed $value): mixed;
}