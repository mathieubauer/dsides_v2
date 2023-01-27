<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Project;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/team")
 */
class UserController extends AbstractController
{
	public function __construct(private readonly EntityManagerInterface $em) {}

	/**
     * @Route("/{slug}", name="user_page")
     */
    public function show(User $user): Response
    {
        // Mieux de passer par une requête directe ? 
        $projects = $this->em->getRepository(Project::class)->findBy(
            [],
            ['displayOrder' => 'ASC']
        );

        $sortedProjects = [];

        foreach ($projects as $project) {
            if ($project->getUsers()->contains($user)) {
                $sortedProjects[] = $project;
            }
        }

        return $this->render('project/index_topic.html.twig', [
            'topic' => $user,
            'projects' => $sortedProjects,
        ]);
    }
}
