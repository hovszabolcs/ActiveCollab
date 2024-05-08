<?php

namespace App\Controller;

use App\Services\ActiveCollab\ActiveCollabClientService;
use Core\ConfigurationInterface;
use Core\HtmlView;
use Core\Request;
use Core\Route\RouteItemInfo;

// You can extends this class for protect your controller from guests
abstract class AuthenticatedController extends AppController
{
    protected readonly ActiveCollabClientService $client;

    public function __construct(ConfigurationInterface $config, Request $request, RouteItemInfo $routeItemInfo)
    {
        parent::__construct($config, $request, $routeItemInfo);

        if (!$this->authService->check()) {
            $view = HtmlView::Redirect('/login');
            $view->render();
            // TODO: all applications should have one start and one exitpoint
            exit();
        }
        $this->client = $this->authService->getClient();
    }

}