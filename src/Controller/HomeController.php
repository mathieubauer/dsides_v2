<?php

namespace App\Controller;

use App\Entity\AboutUs;
use App\Entity\Category;
use App\Entity\Project;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\DoctrineDbalAdapter;
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
		$text = $this->em->getRepository(AboutUs::class);
		$confidential = $text->findOneBy(['reference_page' => 'confidential']);
		return $this->render('home/privacyConfidentiality.html.twig',[
			'title' => 'Politique de confidentialité',
			'confidential' => $confidential
		]);
	}
}
