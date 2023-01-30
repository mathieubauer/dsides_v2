<?php

namespace App\Controller;

use App\Repository\AboutUsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutUsController extends AbstractController
{
    #[Route('/about/us', name: 'app_about_us')]
    public function index(AboutUsRepository $aboutUsRepository): Response
    {
		$text = $aboutUsRepository->findOneBy(['reference_page' => 'about us']);
        return $this->render('about_us/index.html.twig', [
            'title' => 'Qui sommes nous ?',
            'text' => $text
        ]);
    }
}
