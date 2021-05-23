<?php

namespace App\Controller\Admin;

use App\Entity\POEAffix;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class POEAffixCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEAffix::class;
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
