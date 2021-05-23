<?php

namespace App\Controller\Admin;

use App\Entity\POEAffix;
use App\Entity\POEBaseAffixes;
use App\Entity\POEBaseAffixesTier;
use App\Entity\POEItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(POEBaseCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('POE Stash Helper');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Bases', 'fa fa-home');
        yield MenuItem::linkToCrud('Items', 'fas fa-list', POEItem::class);
        yield MenuItem::linkToCrud('Affixes', 'fas fa-list', POEAffix::class);
        yield MenuItem::linkToCrud('Base Affixes', 'fas fa-list', POEBaseAffixes::class);
        yield MenuItem::linkToCrud('Base Affix Tiers', 'fas fa-list', POEBaseAffixesTier::class);
    }
}
