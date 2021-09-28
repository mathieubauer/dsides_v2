<?php

namespace App\Controller\Admin;

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

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(ProjectCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('dsides');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Projets', 'fas fa-list', Project::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-list', Client::class);
        yield MenuItem::linkToCrud('Équipe', 'fas fa-list', User::class);
    }
}
