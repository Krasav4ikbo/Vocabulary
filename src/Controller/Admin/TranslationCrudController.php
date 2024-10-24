<?php

namespace App\Controller\Admin;

use App\Entity\Translation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\LanguageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TranslationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Translation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            LanguageField::new('language')->includeOnly(['en', 'ru', 'sv']),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setSearchFields(['title']);
    }
}
