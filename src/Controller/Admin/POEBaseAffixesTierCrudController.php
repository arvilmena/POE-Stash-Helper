<?php

namespace App\Controller\Admin;

use App\Entity\POEBaseAffixesTier;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class POEBaseAffixesTierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEBaseAffixesTier::class;
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
