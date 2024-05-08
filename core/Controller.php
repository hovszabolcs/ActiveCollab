<?php

namespace Core;

use Core\Route\RouteItemInfo;

abstract class Controller
{
    public function __construct(
        protected readonly ?ConfigurationInterface $config,
        protected readonly Request $request,
        protected readonly RouteItemInfo $routeInfo
    ) {
    }
}