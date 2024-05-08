<?php

namespace App\Controller;

use App\DTO\ProjectDTO;
use Core\TwigView;

class IndexController extends AuthenticatedController
{
    public function index() {
        $projects =  $this->client->getProjects()->getJson();
        $projects = ProjectDTO::fromArray($projects);

        return TwigView::Create('projectlist.html.twig', ['projects' => $projects]);
    }
}