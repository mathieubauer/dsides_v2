<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VimeoController extends AbstractController
{
    #[Route('/vimeo', name: 'app_vimeo')]
    public function index(): Response
    {
        return $this->render('vimeo/index.html.twig', [
            'controller_name' => 'VimeoController',
        ]);
    }
}
