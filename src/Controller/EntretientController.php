<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntretientController extends AbstractController
{
    #[Route('/entretient', name: 'app_entretient')]
    public function index(): Response
    {
        return $this->render('entretient/index.html.twig', [
            'controller_name' => 'EntretientController',
        ]);
    }
}
