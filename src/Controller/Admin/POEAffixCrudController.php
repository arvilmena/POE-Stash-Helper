<?php

namespace App\Controller\Admin;

use App\Entity\POEAffix;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class POEAffixCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return POEAffix::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('a_mod_grp')->setLabel('aModGrp in craftofexile.com'),
            IdField::new('coe_affix_id')->setLabel('affixID in craftofexile.com'),
            TextField::new('regex_pattern'),
        ];
    }
}
