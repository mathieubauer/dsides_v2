<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName'),
            TextField::new('lastName'),
            TextEditorField::new('content'),

            // TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            // ImageField::new('image')->setBasePath('/uploads/images/projects')->setUploadDir('public/uploads/images/projects')->onlyOnIndex()->setSortable(false),

            AssociationField::new('projects')->setFormTypeOptions(['choice_label' => 'name']),

            TextField::new('slug'),
            EmailField::new('email'),
            TextField::new('password')->hideOnIndex(),
            ArrayField::new('roles'),
        ];
    }
}
