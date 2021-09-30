<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('name', 'Nom'),
            TextEditorField::new('content', 'Description')->setSortable(false),

            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image')->setBasePath('/uploads/images/projects')->setUploadDir('public/uploads/images/projects')->onlyOnIndex()->setSortable(false),

            TextField::new('slug'),
            AssociationField::new('client')
                ->setFormTypeOptions(['choice_label' => 'name'])
                ->formatValue(function($value, $entity) {
                    return $entity->getClient()->getName();
                }),
            AssociationField::new('category')->setFormTypeOptions(['choice_label' => 'name']),
            NumberField::new('displayOrder', 'Ordre'),
            BooleanField::new('isDisplayed', 'Affiché ?'),
            BooleanField::new('isFeatured', 'En vedette ?'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Projets',)
            ->setPageTitle('edit', 'Modifier le projet',)
            ->setDefaultSort(['displayOrder' => 'ASC'])
            ;
    }
}
