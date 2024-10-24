<?php

namespace App\Controller\Admin;

use App\Entity\Word;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class WordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Word::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('uuid')->onlyOnIndex(),
            NumberField::new('level'),
            NumberField::new('complexity'),
            CollectionField::new('translations')->onlyOnIndex(),
            AssociationField::new('translations')->onlyOnForms()->setFormTypeOption('by_reference', false),
        ];
    }
}
