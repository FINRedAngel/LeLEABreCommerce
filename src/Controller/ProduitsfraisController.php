<?php

namespace App\Controller;

use App\Entity\SubCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsfraisController extends AbstractController
{
    #[Route('/produitsfrais', name: 'app_produitsFrais')]
    public function produitsfrais(ManagerRegistry $doctrine): Response
    {
        $subcategorys = $doctrine->getRepository(SubCategory::class)->findBy(array('category_id' => 1 ));

        return $this->render('produitsfrais/index.html.twig', [
            'subcategorys' => $subcategorys,
        ]);
    }
}
