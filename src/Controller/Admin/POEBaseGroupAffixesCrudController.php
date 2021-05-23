<?php

namespace App\Controller\Admin;

use App\Entity\POEBaseGroupAffixes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class POEBaseGroupAffixesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEBaseGroupAffixes::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('baseGroup')->autocomplete()->setRequired(true),
            AssociationField::new('poeAffix')->autocomplete()->setRequired(true)
        ];
    }
}
