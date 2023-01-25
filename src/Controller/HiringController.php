<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HiringController extends AbstractController
{
    #[Route('/recrutements', name: 'app_hiring')]
    public function index(): Response
    {
        return $this->render('home/hiring_page.html.twig', [
            'title' => 'Recrutements',
        ]);
    }
}
