<?php

namespace App\Controller\Admin;

use App\Entity\POEItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class POEItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEItem::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('baseGroup')->autocomplete()->setRequired(true)
        ];
    }
}
