<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Project::class);
        $repoCat = $this->getDoctrine()->getRepository(Category::class);

        $projects = $repo->findBy(
            [],
            ['displayOrder' => 'ASC']
        );

        $category = $repoCat->findAll();

        return $this->render('home/index.html.twig', [
            'projects' => $projects,
            'categories' => $category
        ]);
    }
}
