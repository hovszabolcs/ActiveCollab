<?php

namespace App\Controller;

use App\DTO\ProjectDTO;
use Core\Session;
use Core\TwigView;

class IndexController extends AppController
{
    public function index() {
        $session = Session::getInstance();

        // $session->set('test', [1,2,3]);
        // var_dump($session->pull('test'));

        $projects = $this->client->getProjects();
        $projectsDTO = ProjectDTO::fromArray($projects);

        return TwigView::Create('projectlist.html.twig', ['projects' => $projectsDTO]);
    }

    protected function redirectUnauthenticated(): void
    {
        parent::redirectUnauthenticated();
    }
}