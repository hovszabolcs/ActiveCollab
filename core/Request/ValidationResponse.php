<?php

namespace Core\Request;

class ValidationResponse implements \ArrayAccess
{
    protected array $data = [];
    protected array $errors = [];

    public function addError(string $field, string $message) {
        $this->errors[$field] = $message;
    }

    public function addData(string $field, mixed $value) {
        $this->data[$field] = $value;
    }

    public function hasFieldError(string $field): bool {
        return array_key_exists($field, $this->errors);
    }

    public function getError(string $field): ?string {
        return $this->errors[$field] ?? null;
    }

    public function getData(string $field): mixed {
        return $this->data[$field] ?? null;
    }

    public function getAllData(): array {
        return $this->data;
    }

    public function getErrors(): array {
        return $this->errors;
    }

    public function hasError(): bool {
        return !empty($this->errors);
    }

    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }
}