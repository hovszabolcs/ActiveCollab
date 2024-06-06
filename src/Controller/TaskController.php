<?php

namespace App\Controller;

use App\DTO\ProjectDTO;
use App\DTO\TaskDTO;
use Core\TwigView;

class TaskController extends AuthenticatedController
{
    public function listTasks($projectId) {
        $tasks =  $this->client->getTasks($projectId);
        $tasksDTO = TaskDTO::fromArray($tasks['tasks']);

        return TwigView::Create('tasklist.html.twig', [
            'tasks' => $tasksDTO,
            'projectId' => $projectId
        ]);
    }
}