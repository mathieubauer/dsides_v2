<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project')]
class ProjectController extends AbstractController
{
	public function __construct(private readonly EntityManagerInterface $em) {}

	/**
     * @Route("/{id}", name="project_show", requirements={"id":"\d+"})
     * @Route("/{slug}", name="project_show_slug")
     */
	#[Route('/{id}', name: "project_show",requirements: ['id' => '\d+'] )]
	#[Route('/{slug}', name: "project_show_slug",requirements: ['slug' => '[a-zA-Z]+'] )]
    public function show(Project $project): Response
    {
        $category = $this->em->getRepository(Category::class)->findAll();

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'categories' => $category
        ]);
    }

    /**
     * @Route("/reorder", name="reorder")
     */
    public function reorderModules(ManagerRegistry $manager, ProjectRepository $projectRepository):
    RedirectResponse
    {
        // TODO: seulement pour admin
        // TODO: confirmation
        $projects = $projectRepository->findBy(
            [],
            ['displayOrder' => 'ASC']
        );
        $em = $manager->getManager();
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
