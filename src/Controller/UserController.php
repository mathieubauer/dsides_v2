<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/teams')]
class UserController extends AbstractController
{
	public function __construct(private readonly EntityManagerInterface $em) {}

	#[Route('', name: 'app_teams_dsides')]
	public function teamsDsides(): Response
	{
		$users = $this->em->getRepository(User::class)->findAll();
		return $this->render('home/teams.html.twig', [
			'title' => "L'équipe Dsides",
			'teams' => $users
		]);
	}


	#[Route('/hero/{slug}', name: 'user_page')]
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