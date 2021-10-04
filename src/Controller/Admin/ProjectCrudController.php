<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\String\Slugger\SluggerInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectCrudController extends AbstractCrudController
{

    protected $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            TextEditorField::new('content', 'Description')->setSortable(false),

            TextField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image', 'Image')->setBasePath('/uploads/images/projects')->setUploadDir('public/uploads/images/projects')->onlyOnIndex()->setSortable(false),

            TextField::new('featuredImageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('featuredImage', 'Image à la une')->setBasePath('/uploads/images/projects')->setUploadDir('public/uploads/images/projects')->onlyOnIndex()->setSortable(false),

            TextField::new('gridImageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('gridImage', 'Image mosaïque')->setBasePath('/uploads/images/projects')->setUploadDir('public/uploads/images/projects')->onlyOnIndex()->setSortable(false),

            TextField::new('slug')
                ->setHelp("Lien pour l'accès direct (exemple : https://dsides.net/slug)")
                ->onlyOnIndex(),

            AssociationField::new('client')
                ->setFormTypeOptions(['choice_label' => 'name'])
                ->formatValue(function($value, $entity) {
                    return $entity->getClient()->getName();
                }),

            AssociationField::new('category')->setFormTypeOptions(['choice_label' => 'name']),
            // AssociationField::new('users')->setFormTypeOptions(['choice_label' => 'email']),
            NumberField::new('displayOrder', 'Ordre')->onlyOnIndex(),
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

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $projects = $this->getDoctrine()->getRepository(Project::class)->findAll();
        // TODO: reorder avant

        $entityInstance
            ->setDisplayOrder(count($projects) + 1)
            ->setSlug($this->slugger->slug($entityInstance->getName()));

        parent::persistEntity($entityManager, $entityInstance);
    }

}
