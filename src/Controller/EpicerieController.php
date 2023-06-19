<?php

namespace App\Controller;

use App\Entity\SubCategory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EpicerieController extends AbstractController
{
    #[Route('/epicerie', name: 'app_epicerie')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $subcategorys = $doctrine->getRepository(SubCategory::class)->findBy(array('category_id' => 3 ));

        return $this->render('epicerie/index.html.twig', [
            'subcategorys' => $subcategorys,
        ]);
    }
}
