<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Service\OpenGraphService;
use Doctrine\ORM\EntityManagerInterface;
use Leogout\Bundle\SeoBundle\Provider\SeoGeneratorProvider;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/project')]
class ProjectController extends AbstractController
{
	public function __construct(private readonly EntityManagerInterface $em, private readonly OpenGraphService $openGraph) {}

	/**
     * @Route("/{id}", name="project_show", requirements={"id":"\d+"})
     * @Route("/{slug}", name="project_show_slug")
     */
	#[Route('/{id}', name: "project_show",requirements: ['id' => '\d+'] )]
	#[Route('/{slug}', name: "project_show_slug",requirements: ['slug' => '[a-zA-Z]+'] )]
    public function show(Project $project): Response
    {
        $category = $this->em->getRepository(Category::class)->findAll();
		$site_url = $this->generateUrl('project_show', ['id' => $project->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

		$this->openGraph->open_graph($project->getContent(), 'Project', $site_url, $project->getName(), $project->getImage());

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
