<?php

namespace App\Controller;

use App\DTO\ProjectDTO;
use Core\TwigView;

class TaskController extends AuthenticatedController
{
    public function listTasks($projectId) {
        $tasks =  $this->client->getTasks($projectId);
        var_dump($tasks);
        exit();

        $projects = ProjectDTO::fromArray($projects);

        return TwigView::Create('tasklist.html.twig', ['tasks' => $tasks]);
    }
}