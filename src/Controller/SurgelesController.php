<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SurgelesController extends AbstractController
{
    #[Route('/surgeles', name: 'app_surgeles')]
    public function index(): Response
    {
        return $this->render('surgeles/index.html.twig', [
            'controller_name' => 'SurgelesController',
        ]);
    }
}
