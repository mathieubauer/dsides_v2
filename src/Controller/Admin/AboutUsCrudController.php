<?php

namespace App\Controller\Admin;

use App\Entity\AboutUs;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class AboutUsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AboutUs::class;
    }

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setPageTitle(Crud::PAGE_INDEX, 'Text Dynamique')
			->setPageTitle(Crud::PAGE_EDIT, 'Modifier le texte')
			->setPageTitle(Crud::PAGE_NEW, 'Ajouter un nouveau texte')
			->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
	}


    public function configureFields(string $pageName): iterable
    {
        return [
            TextEditorField::new('content', 'Contenu')
                           ->setFormType(CKEditorType::class),
            TextField::new('reference_page', 'Page de référence'),
            BooleanField::new('is_published', 'à publier')
        ];
    }
}
