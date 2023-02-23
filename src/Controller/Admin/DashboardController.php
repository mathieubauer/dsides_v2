<?php

namespace App\Controller\Admin;

use App\Entity\AboutUs;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Project;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractDashboardController
{
	public function __construct(private readonly AdminUrlGenerator $urlGenerator) {}

	/**
     * @Route("/dsidesadmin", name="admin")
     * @IsGranted("ROLE_EDITOR")
     */
    public function index(): Response
    {
        $routeBuilder = $this->urlGenerator->setController(ProjectCrudController::class);
        return $this->redirect($routeBuilder->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('dsides')
            ->setFaviconPath('/img/favicon_dark.jpg');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', 'fa fa-home', 'home');
        // yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        // Projets
        yield MenuItem::section('Projets');
        yield MenuItem::linkToCrud('Projets', 'fas fa-list', Project::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-building', Client::class);
        yield MenuItem::linkToCrud('Équipe', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Text Dynamique', 'fa-solid fa-pen-nib', AboutUs::class);

        // Actions admin
        yield MenuItem::section('Actions admin')
            ->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToRoute('Réordonner', 'fa fa-sort-numeric-down', 'reorder')
            ->setPermission('ROLE_ADMIN');
    }
}
