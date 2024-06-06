<?php

namespace App\Controller;

use App\Helper\MessageType;
use App\Services\ActiveCollab\ActiveCollabAuthService;
use App\Services\AuthService;
use App\Services\CacheService\CacheInterface;
use App\Services\CacheService\RedisCache;
use Core\ConfigurationInterface;
use Core\Controller;
use Core\HtmlView;
use Core\Request;
use Core\Route\RouteItemInfo;

// all public controller may extends from AppController
abstract class AppController extends Controller
{
    protected CacheInterface $cache;
    protected AuthService $authService;
    protected ActiveCollabAuthService $apiService;

    public function __construct(ConfigurationInterface $config, Request $request, RouteItemInfo $routeItemInfo)
    {
        parent::__construct($config, $request, $routeItemInfo);

        $this->apiService = new ActiveCollabAuthService();
        $this->authService = new AuthService($request->session, $this->apiService);
        $this->cache = $this->makeCacheHandlerInstance($config);

        if ($this->request->session->has('siteMessage')) {
            HtmlView::setParam('siteMessage', $this->request->session->pull('siteMessage'));
        }
    }

    public function message(MessageType $type, string $message) {
        $this->request->session->set('siteMessage', ['type' => $type, 'text' => $message]);
    }

    public function getCacheHandler(): CacheInterface {
        return $this->cache;
    }

    protected function makeCacheHandlerInstance(ConfigurationInterface $config): CacheInterface {
        $redisUrl = $config->getEnv('REDIS_URL');
        return new RedisCache($redisUrl);
    }
}