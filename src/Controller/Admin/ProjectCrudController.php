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

            AssociationField::new('client')
                ->setFormTypeOptions(['choice_label' => 'name'])
                ->formatValue(function ($value, $entity) {
                    return $entity->getClient()->getName();
                }),

            AssociationField::new('category', 'Catégories')
                ->setFormTypeOptions(['choice_label' => 'name']),

            TextEditorField::new('content', 'Description')
                ->setSortable(false)
                ->hideOnIndex(),

            

            TextField::new('featuredImageFile', 'Image à la une')
                ->setFormType(VichImageType::class)
                ->hideOnIndex()
                ->setHelp("Affichage seulement quand le projet est mis à la une"),

            ImageField::new('featuredImage', 'Image à la une')
                ->setBasePath('/uploads/images/projects')
                ->setUploadDir('public/uploads/images/projects')
                ->onlyOnIndex()
                ->setSortable(false),

            TextField::new('gridImageFile', 'Image mosaïque')
                ->setFormType(VichImageType::class)
                ->hideOnIndex()
                ->setHelp("Affichage quand le projet n'est pas mis à la une"),

            ImageField::new('gridImage', 'Image mosaïque')
                ->setBasePath('/uploads/images/projects')
                ->setUploadDir('public/uploads/images/projects')
                ->onlyOnIndex()
                ->setSortable(false),

            TextField::new('imageFile', 'Image par défaut')
                ->setFormType(VichImageType::class)
                ->hideOnIndex()
                ->setHelp("Affichage en en-tête de la fiche"),

            ImageField::new('image', 'Image par défaut')
                ->setBasePath('/uploads/images/projects')
                ->setUploadDir('public/uploads/images/projects')
                ->onlyOnIndex()
                ->setSortable(false),

            
            // AssociationField::new('users')->setFormTypeOptions(['choice_label' => 'email']),
            NumberField::new('displayOrder', 'Ordre')
                ->setPermission('ROLE_ADMIN'),

            BooleanField::new('isDisplayed', 'Affiché ?'),

            BooleanField::new('isFeatured', 'À la une ?'),
                // ->setCssClass('mb-5') // fait bugger la modification du toggle button

            TextField::new('slug')
                ->setHelp("Lien pour l'accès direct (exemple : https://dsides.net/slug)")
                ->hideOnIndex()
                ->setPermission('ROLE_ADMIN'),

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
