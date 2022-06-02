<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator
use Symfony\Component\HttpFoundation\Request; // Nous avons besoin d'accéder à la requête pour obtenir le numéro de page

class AnnoncesController extends AbstractController
{
    #[Route('/annonces', name: 'main_annonces')]
    public function listesannonces(Request $request, PaginatorInterface $paginator, AnnoncesRepository $annoncesRepository): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Annonces::class)->findAll();
        $annonces = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        

        return $this->render('main/annonces.html.twig', [
            'annonces' => $annonces
        ]);
        
    }
    
    
}
