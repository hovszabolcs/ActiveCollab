<?php

namespace Core;

use Core\Request\TypeCheckerInterface;
use Core\Request\TypeCheckErrorException;
use Core\Request\ValidationResponse;

class Request {
    protected RequestMethodEnum $requestMethod;

    protected static Request $self;

    public readonly Session $session;

    public readonly string $uri;
    public static function Make(): static {
        if (isset(static::$self))
            return static::$self;

        $self = new static;
        $self->session = Session::getInstance();
        $self->requestMethod = $self->calculateRequestMethod();
        $self->uri = strstr($_SERVER['REQUEST_URI'], '?', true) ?: $_SERVER['REQUEST_URI'];

        return $self;
    }

    protected function __construct() {}

    public function getQuery(string $name, TypeCheckerInterface $type, $default = null): mixed {
        return $this->getData(INPUT_GET, $name, $type, $default);
    }

    public function getPost($name, TypeCheckerInterface $type, $default = null): mixed {
        return $this->getData(INPUT_POST, $name, $type, $default);
    }

    // TODO: getCookie...

    public function getMethod(): RequestMethodEnum {
        return $this->requestMethod;
    }

    public function validatePostData(array $fields): ValidationResponse {
        $response = new ValidationResponse();
        foreach ($fields as $name => $typeChecker) {
            $value = $typeChecker->sanitize($this->getPost($name, $typeChecker));
            try {
                $typeChecker->check($value);
            } catch (TypeCheckErrorException $e) {
                $response->addError($name, $e->getMessage());
            }
            finally {
                $response->addData($name, $value);
            }
        }

        return $response;
    }

    // TODO: Separate validation to a Validation class but no time for sophistication
    private function getData(int $from, string $name, TypeCheckerInterface $type, $default = null): mixed {
        $value = filter_input($from, $name);
        // TODO: Very very simple - collect errors and values to an object
        return $type->typeCheck($value) ? $value : $default;
    }

    protected function calculateRequestMethod(): ?RequestMethodEnum {
        return RequestMethodEnum::tryFrom(strtolower($_SERVER['REQUEST_METHOD']));
    }
}