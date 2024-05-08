<?php

namespace App\Controller;

use App\Helper\MessageType;
use App\Services\AuthService;
use App\Services\ActiveCollab\ActiveCollabAuthService;
use App\Services\RedisCache;
use Core\ConfigurationInterface;
use Core\Controller;
use Core\HtmlView;
use Core\Request;
use Core\Route\RouteItemInfo;

// all public controller may extends from AppController
abstract class AppController extends Controller
{
    protected AuthService $authService;
    protected ActiveCollabAuthService $apiService;

    public function __construct(ConfigurationInterface $config, Request $request, RouteItemInfo $routeItemInfo)
    {
        $redis = new RedisCache('redis');

        exit();

        parent::__construct($config, $request, $routeItemInfo);

        $this->apiService = new ActiveCollabAuthService();
        $this->authService = new AuthService($request->session, $this->apiService);

        if ($this->request->session->has('siteMessage')) {
            HtmlView::setParam('siteMessage', $this->request->session->pull('siteMessage'));
        }
    }

    public function message(MessageType $type, string $message) {
        $this->request->session->set('siteMessage', ['type' => $type, 'text' => $message]);
    }

}