<?php

use App\Controller\AuthController;
use App\Controller\IndexController;
use App\Controller\TaskController;
use App\Controller\TestController;
use Core\RequestMethodEnum;

return [
    '/'                                 => [IndexController::class, 'index'],
    '/login'                            => [AuthController::class, 'login', [RequestMethodEnum::POST, RequestMethodEnum::GET]],
    '/project/{projectID:int}/tasks'    => [TaskController::class, 'listTasks'],
    '/test/{phone:phone}/show'          => [TestController::class, 'index']
];
