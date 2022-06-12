<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    #[Route('/video', name: 'main_video')]
    public function index(): Response
    {
        return $this->render('main/videos.html.twig', [
            'controller_name' => 'VideoController',
        ]);
    }
}
