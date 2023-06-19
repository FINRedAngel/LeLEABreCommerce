<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoissonsController extends AbstractController
{
    #[Route('/boissons', name: 'app_boissons')]
    public function index(): Response
    {
        return $this->render('boissons/index.html.twig', [
            'controller_name' => 'BoissonsController',
        ]);
    }
}
