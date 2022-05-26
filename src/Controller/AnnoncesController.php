<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnoncesController extends AbstractController
{
    #[Route('/annonces', name: 'main_annonces')]
    public function listesannonces(AnnoncesRepository $annoncesRepository): Response
    {
        $projets = $annoncesRepository->findby([]);
        return $this->render('main/annonces.html.twig', [
            'controller_name' => 'AnnoncesController',
        ]);
    }
}
