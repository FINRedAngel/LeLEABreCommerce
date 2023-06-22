<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\SubCategory;
use App\Service\CartService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, CartService $cartService): Response
    {
        $products = $doctrine->getRepository(Product::class)->findAll();
        $subcategorylists = $doctrine->getRepository(SubCategory::class)->findAll();

        return $this->render('index.html.twig', [
            'products' => $products,
            'cart' => $cartService->getTotal(),
            'subcategorylists' => $subcategorylists
        ]);
    }

    #[Route('/produit/{id<\d+>}', name: 'app_produit')]
    public function produit(ManagerRegistry $doctrine, CartService $cartService, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->findOneBy(array('id' => $id));
        $subcategorylists = $doctrine->getRepository(SubCategory::class)->findAll();

        return $this->render('produit.html.twig', [
            'product' => $product,
            'cart' => $cartService->getTotal(),
            'subcategorylists' => $subcategorylists,
        ]);
    }

    #[Route('/produit/add/{id<\d+>}', name: 'product_add')]
    public function addToCart(CartService $cartService, int $id): Response
    {
        $cartService->addToCart($id);

        return $this->redirectToRoute('app_produit', array('id' => $id));
    }

    #[Route('/produit/decrease/{id<\d+>}', name: 'product_decrease')]
    public function decrease(CartService $cartService, $id): RedirectResponse
    {
        $cartService->decrease($id);

        return $this->redirectToRoute('app_produit', array('id' => $id));
    }

    #[Route('/produit/remove/{id<\d+>}', name: 'product_remove')]
    public function removeToCart(CartService $cartService, int $id): Response
    {
        $cartService->removeToCart($id);

        return $this->redirectToRoute('app_produit', array('id' => $id));
    }
}