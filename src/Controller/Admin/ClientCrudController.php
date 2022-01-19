<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('slug')
                ->setPermission('ROLE_ADMIN'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $go = Action::new('go')->linkToRoute('client_page', function (Client $client): array {
            return [
                'slug' => $client->getSlug(),
            ];
        });
        return $actions->add(Crud::PAGE_INDEX, $go);
    }
}
