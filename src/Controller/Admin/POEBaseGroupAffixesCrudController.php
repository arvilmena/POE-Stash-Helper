<?php

namespace App\Controller\Admin;

use App\Entity\POEBaseGroupAffixes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class POEBaseGroupAffixesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEBaseGroupAffixes::class;
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
