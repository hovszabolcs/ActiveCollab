<?php

namespace App\Controller;

use App\Services\ActiveCollab\ActiveCollabCachedClient;
use App\Services\ActiveCollab\ActiveCollabClientInterface;
use Core\ConfigurationInterface;
use Core\HtmlView;
use Core\Request;
use Core\Route\RouteItemInfo;

// You can extends this class for protect your controller from guests
abstract class AuthenticatedController extends AppController
{
    protected readonly ActiveCollabClientInterface $client;

    public function __construct(ConfigurationInterface $config, Request $request, RouteItemInfo $routeItemInfo)
    {
        parent::__construct($config, $request, $routeItemInfo);

        $this->redirectUnauthenticated();

        $this->client = $this->getClient();
    }

    protected function getClient(): ?ActiveCollabClientInterface {
        return new ActiveCollabCachedClient($this->authService->getClient(), $this->cache);
    }

    protected function redirectUnauthenticated(): void {
        if (!$this->authService->check()) {
            $view = HtmlView::Redirect('/login');
            $view->render();
            exit();
        }
    }

}