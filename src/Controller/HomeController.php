<?php

namespace App\Controller;

use App\Entity\AboutUs;
use App\Repository\CategoryRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
	public function __construct(
		private readonly EntityManagerInterface $em,
	) {}

	/**
	 * @Route("/", name="home")
	 * @throws \Psr\Cache\InvalidArgumentException
	 */
    public function index( ProjectRepository $repo, CategoryRepository $repoCat ): Response
    {
		$projects = $repo->findBy(
				[],
				['displayOrder' => 'ASC']
			);
        return $this->render('home/index.html.twig', [
            'projects' => $projects,
            'categories' => $repoCat->findAll()
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
