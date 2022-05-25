<?php

namespace App\Controller\Utilisateur;

use App\Entity\Annonces;
use App\Entity\Commentaire;
use App\Entity\Projet;
use App\Form\AnnoncesType;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/utilisateur", name="utilisateur_")
 */
class utilisateurController extends AbstractController
{
    // // liste l'ensemble des projets
    /**
     * @Route("/projet", name="listesProjet")
     */
    public function listesProjet(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findby([]);

        return $this->render('utilisateur/commentaires.html.twig', [
            'projets' => $projets,
        ]);
    }

    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function commentaire(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('utilisateur_listesProjet');
        }

        return $this->render('utilisateur/ajoutCommentaire.html.twig', [
            "commentaires" => $commentaire,
            "form" => $form->createView()
        ]);
    }
// Ajout d'une annonces
    /**
     * @Route("/annonces", name="ajoutAnnonce")
     */
    public function ajoutAnnonce(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonce = new Annonces();

        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $annonce->setUtilisateur($this->getUser());
            $annonce->setActive(false);

            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();
            $this->addFlash("success", "L'ajout a été effectuée");
            return $this->redirectToRoute('utilisateur_listesProjet');
        }
        return $this->render('utilisateur/ajoutAnnonces.html.twig', [
            "form" => $form->createView(),
        ]);
    }

}
