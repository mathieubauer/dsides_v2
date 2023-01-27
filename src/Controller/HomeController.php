<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	public function __construct(private readonly EntityManagerInterface $em) {}

	/**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $repo = $this->em->getRepository(Project::class);
        $repoCat = $this->em->getRepository(Category::class);

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

	#[Route('/confidentiality', name:'app_privacy_confidentiality')]
	public function privacyConfidentiality(): Response
	{
		return $this->render('home/privacyConfidentiality.html.twig',[
			'title' => 'Politique de confidentialité'
		]);
	}
}
