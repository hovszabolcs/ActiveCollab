<?php

namespace Core;

use Core\Exception\NotFoundException;
use Throwable;

class Application {

    private string $rootDir;

    public function __construct(
        private ConfigurationInterface $config,
        private RouterInterface $router) {
    }

    public function getRootDir(): string {
        return $this->rootDir;
    }

    public function run(): void {
        try {
            $view = $this->router->call();
            $view && $view->render();
        }
        catch (NotFoundException $exception) {
            http_response_code(404);
        }
        catch (Throwable $exception) {
            // TODO: log error context
            if (!$this->config->getEnv('DEBUG')) {
                http_response_code(500);
            }
            throw $exception;
        }
    }

}