<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
	public function __construct(private readonly EntityManagerInterface $em) {}

	/**
     * @Route("/{slug}", name="category_page")
     */
    public function show(Category $category): Response
    {
        // Mieux de passer par une requête directe ?
        $projects = $this->em->getRepository(Project::class)->findBy(
            [],
            ['displayOrder' => 'ASC']
        );
        $sortedProjects = [];
        foreach ($projects as $project) {
            if ($project->getCategory()->contains($category)) {
                $sortedProjects[] = $project;
            }
        }
        return $this->render('project/index_topic.html.twig', [
            'topic' => $category,
            'projects' => $sortedProjects,
        ]);

    }
}
