<?php

namespace App\Services\ActiveCollab;

use ActiveCollab\SDK\TokenInterface;
use App\Services\CacheService\CacheInterface;

class ActiveCollabCachedClient implements ActiveCollabClientInterface
{
    public int $cacheExpire = 10;

    public function __construct(
        protected ActiveCollabClientInterface $activeCollabClient,
        protected CacheInterface $cache
    ) {}
    public function getToken(): TokenInterface {
        return $this->activeCollabClient->getToken();
    }

    public function getProjects(): array
    {
        return $this->cache->get( 'projects_' . $this->getToken()->getToken(), $this->cacheExpire, function() {
            return $this->activeCollabClient->getProjects();
        });
    }

    public function getTasks(int $projectId): array
    {
        return $this->cache->get( "tasks_{$projectId}_" . $this->getToken()->getToken(), $this->cacheExpire,
            function() use ($projectId) {
                return $this->activeCollabClient->getTasks($projectId);
            }
        );
    }
}