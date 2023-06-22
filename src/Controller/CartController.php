<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\SubCategory;
use Doctrine\Persistence\ManagerRegistry;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/monpanier', name: 'app_cart')]
    public function index(ManagerRegistry $doctrine, CartService $cartService): Response
    {
        $subcategorylists = $doctrine->getRepository(SubCategory::class)->findAll();
        
        return $this->render('cart/index.html.twig', [
           'cart' => $cartService->getTotal(),
           'subcategorylists' => $subcategorylists,
        ]);
    }

    #[Route('/monpanier/add/{id<\d+>}', name: 'cart_add')]
    public function addToCart(CartService $cartService, int $id): Response
    {
        $cartService->addToCart($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/monpanier/remove/{id<\d+>}', name: 'cart_remove')]
    public function removeToCart(CartService $cartService, int $id): Response
    {
        $cartService->removeToCart($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/monpanier/decrease/{id<\d+>}', name: 'cart_decrease')]
    public function decrease(CartService $cartService, $id): RedirectResponse
    {
        $cartService->decrease($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/monpanier/removeAll', name: 'cart_removeAll')]
    public function removeAll(CartService $cartService): Response
    {
        $cartService->revoveCartAll();

        return $this->redirectToRoute('app_cart');
    }
}