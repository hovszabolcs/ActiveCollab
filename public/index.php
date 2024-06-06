<?php
use App\CustomRouter;
use Core\Application;
use Core\Configuration;
use Core\Request;
use Core\Router;

require '../vendor/autoload.php';

define('APP_ROOT', dirname(__DIR__));
define('SOURCE_DIR',  APP_ROOT . '/src');

// -------------- Bootstrap -------------------
$config = new Configuration(APP_ROOT, SOURCE_DIR);

define('PUBLIC_DIR', APP_ROOT . '/public');
define('CACHE_DIR', APP_ROOT . '/cache');

define('TEMPLATE_DIR', $config->getEnv('TEMPLATE_DIR', SOURCE_DIR . '/Templates'));
// Twig integration
define('TEMPLATE_CACHE_DIR', $config->getEnv('TEMPLATE_CACHE_DIR', CACHE_DIR . '/templates'));
define('DEBUG', $config->getEnv('DEBUG'));

// convert error to exception
set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

$routes         = include SOURCE_DIR . '/Route/route.php';
$routeVarTypes  = include SOURCE_DIR . '/Route/types.php';

$router = new Router($config, Request::Make(), $routes, $routeVarTypes);

(new Application($config, $router))->run();