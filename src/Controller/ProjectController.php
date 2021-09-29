<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 */
class ProjectController extends AbstractController
{

    /**
     * @Route("/{id}", name="project_show", requirements={"id":"\d+"})
     */
    public function show(Project $project, Request $request): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }
}
