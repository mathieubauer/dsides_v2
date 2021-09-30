<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
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

    /**
     * @Route("/clean_displayOrder", name="clean_displayOrder")
     */
    public function reorderModules(Request $request, ProjectRepository $projectRepository)
    {

        // TODO: seulement pour admin
        // TODO: confirmation

        $projects = $projectRepository->findBy(
            [],
            ['displayOrder' => 'ASC']
        );

        $em = $this->getDoctrine()->getManager();
        $i = 1;
        foreach ($projects as $project) {
            $project->setDisplayOrder($i);
            $em->persist($project);
            $i++;
        }
        $em->flush();

        return $this->redirectToRoute('home');
    }

}
