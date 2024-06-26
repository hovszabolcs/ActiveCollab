<?php

namespace App\Services;

use App\Services\ActiveCollab\ActiveCollabAuthService;
use App\Services\ActiveCollab\ActiveCollabClientInterface;
use Core\Session;

class AuthService
{
    public function __construct (
        protected Session $session,
        protected ActiveCollabAuthService $apiAuthService
    ) {}

    public function login(string $name, string $password): ?ActiveCollabClientInterface {
        if ($this->session->has('client'))
            return $this->session->get('client');

        $client = $this->apiAuthService->login($name, $password);
        if (!$client)
            return null;

        $this->session->set('client', $client);
        return $client;
    }
    public function check(): bool {
        return $this->session->has('client');
    }

    public function logout(): void {
        $this->session->delete('client');
    }

    public function getClient(): ?ActiveCollabClientInterface {
        return $this->session->get('client');
    }
}