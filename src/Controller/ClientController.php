<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/{slug}", name="client_page")
     */
    public function show(Client $client): Response
    {

        $projects = $this->getDoctrine()->getRepository(Project::class)->findBy(
            ['client' => $client],
            ['displayOrder' => 'ASC']
        );

        return $this->render('home/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}
