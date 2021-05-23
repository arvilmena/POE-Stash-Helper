<?php

namespace App\Controller\Admin;

use App\Entity\POEItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class POEItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEItem::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
