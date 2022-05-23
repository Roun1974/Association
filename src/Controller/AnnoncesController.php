<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnoncesController extends AbstractController
{
    #[Route('/annonces', name: 'main_annonces')]
    public function index(): Response
    {
        return $this->render('main/annonces.html.twig', [
            'controller_name' => 'AnnoncesController',
        ]);
    }
}
