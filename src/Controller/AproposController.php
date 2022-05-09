<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AproposController extends AbstractController
{
    #[Route('/apropos', name: 'app_apropos')]
    public function index(): Response
    {
        return $this->render('main/apropos.html.twig', [
            'controller_name' => 'AproposController',
        ]);
    }
}
