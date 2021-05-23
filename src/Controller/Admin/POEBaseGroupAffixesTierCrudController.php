<?php

namespace App\Controller\Admin;

use App\Entity\POEBaseGroupAffixesTier;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class POEBaseGroupAffixesTierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEBaseGroupAffixesTier::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('baseGroupAffixes')->autocomplete()->setRequired(true),
            TextField::new('name'),
            NumberField::new('tier'),
            NumberField::new('ilvl'),
            NumberField::new('min'),
            NumberField::new('max'),
        ];
    }
}
