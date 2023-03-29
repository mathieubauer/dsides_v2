<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            EmailField::new('email'),
            TextField::new('firstName', 'Nom du héro'),
            TextField::new('lastName', 'Prénom du héro'),
            TextField::new('imageFile', 'Portrait du Héro')
                     ->setFormType(VichImageType::class)
                     ->hideOnIndex()
                     ->hideOnDetail()
                     ->setHelp('Portrait du héro Dsides'),

            ImageField::new('image','Portrait Héro')
                      ->setBasePath('/uploads/images/teams')
                      ->setUploadDir('public/uploads/images/teams')
                      ->onlyOnIndex()
                      ->setSortable(false),

            ImageField::new('image','Portrait Héro')
                      ->setTemplatePath('/admin/user/image.html.twig')
                      ->setHelp('Portrait du héro Dsides')
                      ->onlyOnDetail(),
            TextEditorField::new('content'),
            AssociationField::new('projects')
                     ->setFormTypeOptions(['choice_label' => 'name'])
                     ->hideOnIndex(),

            TextField::new('password')
                     ->hideOnIndex()
                     ->hideOnDetail()
                     ->hideWhenUpdating()
                     ->setFormType(PasswordType::class),

            ChoiceField::new('roles')
                       ->setChoices([
	                                    'Utilisateur' => 'ROLE_USER',
	                                    'Administrateur' => 'ROLE_ADMIN'
                                    ])
                       ->allowMultipleChoices()
                       ->renderAsBadges()
                       ->setPermission('ROLE_ADMIN'),

            TextField::new('slug')
                     ->setPermission('ROLE_ADMIN'),
            TextField::new('jobs', 'Job Title')
        ];
    }

	public function configureActions(Actions $actions): Actions
	{
		return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInSingular('Héro Dsides')
			->setEntityLabelInPlural('Héros Dsides')
			->setPageTitle('edit',
				fn (User $user) => sprintf('Mise à jour de <b>%s</b>', $user->getFullname()))
			->setPageTitle('detail',
				fn (User $user) => sprintf('Fiche detail de <b>%s</b>', $user->getFullname()));
	}
}
