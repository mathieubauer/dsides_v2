<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
	public function __construct(private readonly EntityManagerInterface $em) {}
	/**
     * @Route("/{slug}", name="client_page")
     */
    public function show(Client $client): Response
    {
        $projects = $this->em->getRepository(Project::class)->findBy(
            ['client' => $client],
            ['displayOrder' => 'ASC']
        );
        return $this->render('project/index_topic.html.twig', [
            'topic' => $client,
            'projects' => $projects,
        ]);
    }
}
