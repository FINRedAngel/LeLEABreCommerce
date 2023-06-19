<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\SubCategory;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ProductCrudController::class)->generateUrl();

        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(ProductCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LeLEABreCommerce');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Retour au Site', 'fas fa-home', 'app_home');

        yield MenuItem::section('Produits');
        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Crée Produit', 'fas fa-plus', Product::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir Produits', 'fas fa-plus', Product::class)
        ]);

        yield MenuItem::section('Category');
        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Crée Category', 'fas fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir Category', 'fas fa-plus', Category::class)
        ]);

        yield MenuItem::section('SubCategory');
        yield MenuItem::subMenu('Action', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Crée SubCategory', 'fas fa-plus', SubCategory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir SubCategory', 'fas fa-plus', SubCategory::class)
        ]);
    }
}
