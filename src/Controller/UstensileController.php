<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UstensileController extends AbstractController
{
    #[Route('/ustensile', name: 'app_ustensile')]
    public function index(): Response
    {
        return $this->render('ustensile/index.html.twig', [
            'controller_name' => 'UstensileController',
        ]);
    }
}
