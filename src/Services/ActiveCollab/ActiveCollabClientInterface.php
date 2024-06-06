<?php

namespace App\Services\ActiveCollab;

use ActiveCollab\SDK\TokenInterface;

interface ActiveCollabClientInterface
{
    public function getToken(): TokenInterface;

    public function getProjects(): array;

    public function getTasks(int $projectId): array;
}