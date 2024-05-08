<?php

namespace Core;

use Core\Exception\NotFoundException;
use Core\Route\RouteItemInfo;
use Core\Route\RouteVariable;

class Router implements RouterInterface {

    public function __construct(
        private ConfigurationInterface $config,
        private Request $request,
        protected array $routeData,
        protected array $varTypes
    ) {
    }

    protected function parseVariableValues(RouteItemInfo $routeItemInfo, array $matches) {
        array_shift($matches);
        foreach ($routeItemInfo->getVariables() as $variable) {
            $variable->value = array_shift($matches);
        }

        return $routeItemInfo;
    }

    public function call(): ?Renderable {
        $uri = $this->request->uri;

        $routeItem = $this->findRoute($uri);

        if (!$routeItem)
            $this->throwNotFoundException();

        if (!in_array($this->request->getMethod(), $routeItem->getAllowedMethods())
        ) {
                $this->throwNotFoundException();
        }
        $controllerClassName = $routeItem->getControllerClassName();
        $actionName = $routeItem->getActionName();

        $controller = new $controllerClassName($this->config, $this->request, $routeItem);
        return $controller->$actionName(...array_column($routeItem->getVariables(), 'value'));
    }

    protected function findRoute($uri): ?RouteItemInfo {
        $routeInfo = $this->makeRouteInfo();
        foreach ($routeInfo as $routeItemInfo) {
            if (preg_match($routeItemInfo->getPattern(), $uri, $matches)) {

                $routeConfigItem = $this->routeData[$routeItemInfo->getOriginalPattern()];
                $routeConfigItem = array_pad($routeConfigItem, 3, null);

                list($controller, $action, $allowedRequestMethods) = $routeConfigItem;

                $routeItemInfo
                    ->setControllerClassName($controller)
                    ->setActionName($action)
                    ->setAllowedMethods($allowedRequestMethods);

                $this->parseVariableValues($routeItemInfo, $matches);
                return $routeItemInfo;
            }
        }
        return null;
    }

    /** @return array<RouteItemInfo> */
    protected function makeRouteInfo(): array {
        $routeInfo = [];

        foreach ($this->routeData as $uri => $routeData) {
            $routeItemInfo = $this->makeRouteInfoInstance($uri);
            $variables = [];
            $pattern = preg_replace_callback('~{([a-z_][a-z_0-9]+)(?::([a-z]+))?}~iu', function ($match) use (&$variables, $routeItemInfo) {
                $var = new RouteVariable();
                $var->name = $match[1];
                $var->type = $match[2] ?? 'string';

                $routeItemInfo->addVariable($var);
                return '(' . $this->varTypes[$var->type] . ')';
            }, $uri);
            $routeItemInfo->setPattern("#^$pattern$#ui");
            $routeInfo[] = $routeItemInfo;
        }

        return $routeInfo;
    }

    protected function makeRouteInfoInstance(string $uri): RouteItemInfo {
        return new RouteItemInfo($uri);
    }

    protected function throwNotFoundException(): void {
        throw new NotFoundException('Page not found.', 404);
    }

}