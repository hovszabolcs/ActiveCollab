<?php

namespace Core\Route;

use Core\RequestMethodEnum;

class RouteItemInfo
{
    protected string $controllerClassName;
    protected string $actionName;
    protected array $allowedMethods;

    protected string $originalPattern = '';
    protected string $pattern = '';
    protected array $variables = [];

    public function __construct(string $originalPattern) {
        $this->setOriginalPattern($originalPattern);
    }

    public function setOriginalPattern(string $pattern): static {
        $this->originalPattern = $pattern;
        return $this;
    }

    public function getOriginalPattern(): string {
        return $this->originalPattern;
    }

    public function setPattern(string $pattern): void {
        $this->pattern = $pattern;
    }

    public function getPattern(): string {
        return $this->pattern;
    }

    public function addVariable(RouteVariable $var): void {
        $this->variables[] = $var;
    }

    public function getVariables(): array {
        return $this->variables;
    }

    public function getControllerClassName(): string {
        return $this->controllerClassName;
    }

    public function setControllerClassName(string $controllerClassName): static {
        $this->controllerClassName = $controllerClassName;
        return $this;
    }

    public function getActionName(): string {
        return $this->actionName;
    }

    public function setActionName(string $actionName): static {
        $this->actionName = $actionName;
        return $this;
    }

    public function getAllowedMethods(): array {
        return $this->allowedMethods;
    }

    public function setAllowedMethods(?array $allowedMethods): static {
        if ($allowedMethods === null)
            $allowedMethods = [RequestMethodEnum::GET];

        if (in_array(RequestMethodEnum::ANY, $allowedMethods, true))
            $allowedMethods = [
                RequestMethodEnum::GET,
                RequestMethodEnum::POST,
                RequestMethodEnum::PUT,
                RequestMethodEnum::DELETE,
                RequestMethodEnum::PATCH
            ];

        $this->allowedMethods = $allowedMethods;
        return $this;
    }
}