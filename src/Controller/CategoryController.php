<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{slug}", name="category_page")
     */
    public function show(Category $category): Response
    {

        // Mieux de passer par une requête directe ? 

        $projects = $this->getDoctrine()->getRepository(Project::class)->findBy(
            [],
            ['displayOrder' => 'ASC']
        );

        $sortedProjects = [];

        foreach ($projects as $project) {
            if ($project->getCategory()->contains($category)) {
                $sortedProjects[] = $project;
            }
        }

        return $this->render('home/index.html.twig', [
            'projects' => $sortedProjects,
        ]);
        
    }
}
