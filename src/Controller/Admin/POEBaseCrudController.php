<?php

namespace App\Controller\Admin;

use App\Entity\POEBase;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class POEBaseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEBase::class;
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
