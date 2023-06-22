<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\SubCategory;
use App\Service\CartService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoissonsController extends AbstractController
{
    #[Route('/boissons', name: 'app_boissons')]
    public function index(ManagerRegistry $doctrine, CartService $cartService): Response
    {
        $subcategorys = $doctrine->getRepository(SubCategory::class)->findBy(array('category_id' => 4));
        $subcategorylists = $doctrine->getRepository(SubCategory::class)->findAll();
        
        return $this->render('boissons/index.html.twig', [
            'subcategorys' => $subcategorys,
            'subcategorylists' => $subcategorylists,
            'cart' => $cartService->getTotal()
        ]);
    }

    #[Route('/boissons/{name}', name: 'app_boissonsProduit')]
    public function produit(ManagerRegistry $doctrine,string $name, CartService $cartService): Response
    {
        $subcategory = $doctrine->getRepository(SubCategory::class)->findOneBy(array('name' => $name));
        $subcategoryproduits = $doctrine->getRepository(Product::class)->findBy(array('subcategory_id' => $subcategory));
        $subcategorylists = $doctrine->getRepository(SubCategory::class)->findAll();

        return $this->render('boissons/produit.html.twig', [
            'subcategory' => $subcategory,
            'subcategoryproduits' => $subcategoryproduits,
            'subcategorylists' => $subcategorylists,
            'cart' => $cartService->getTotal()
        ]);
    }
}
