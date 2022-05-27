<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnoncesController extends AbstractController
{
    #[Route('/annonces', name: 'main_annonces')]
    public function listesannonces(AnnoncesRepository $annoncesRepository): Response
    {
        $annonce = $this->getDoctrine()->getRepository(Annonces::class)->findAll();
        return $this->render('main/annonces.html.twig', [
            'annonces' => $annonce
        ]);
    }
}
