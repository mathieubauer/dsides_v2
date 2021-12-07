<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProjectController extends AbstractController
{

    /**
     * @Route("/project/{id}", name="project_show", requirements={"id":"\d+"})
     * @Route("/{slug}", name="project_show_slug")
     */
    public function show(Project $project, Request $request): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'categories' => $category
        ]);
    }

    /**
     * @Route("/project/reorder", name="reorder")
     */
    public function reorderModules(Request $request, ProjectRepository $projectRepository): RedirectResponse
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

        return $this->redirectToRoute('admin');
    }

}
