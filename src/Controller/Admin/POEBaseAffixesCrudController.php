<?php

namespace App\Controller\Admin;

use App\Entity\POEBaseAffixes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class POEBaseAffixesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEBaseAffixes::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('baseGroup')->autocomplete()->setRequired(true),
            AssociationField::new('poeAffix')->autocomplete()->setRequired(true)
        ];
    }
}
