<?php

namespace App\Controller;

use App\DTO\ProjectDTO;
use Core\TwigView;

class IndexController extends AuthenticatedController
{
    public function index() {
        $projects = $this->client->getProjects();
        $projectsDTO = ProjectDTO::fromArray($projects);

        return TwigView::Create('projectlist.html.twig', ['projects' => $projectsDTO]);
    }
}