<?php

namespace App\Services\ActiveCollab;

use ActiveCollab\SDK\Client;
use ActiveCollab\SDK\ClientInterface;
use ActiveCollab\SDK\ResponseInterface;
use ActiveCollab\SDK\TokenInterface;

class ActiveCollabClientService
{
    protected ClientInterface $client;

    public function __construct(
        protected TokenInterface $token
    ) {
        $this->client = $this->makeClientInstance($token);
    }

    // You can use any customized Client class
    protected function makeClientInstance(TokenInterface $token): ClientInterface {
        return new Client($token);
    }

    public function getToken(): TokenInterface {
        return $this->token;
    }

    public function getProjects(): array {
        return $this->client->get('projects')->getJson();
    }

    public function getTasks(int $projectId): array {
        return $this->client->get(sprintf('projects/%d/tasks?assignee_id=2', $projectId))->getJson();
    }
}