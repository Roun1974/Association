<?php

namespace App\Controller\Utilisateur;

use App\Entity\Annonces;
use App\Entity\Commentaire;
use App\Entity\Comments;
use DateTime;
use App\Entity\Projet;
use App\Entity\Utilisateur;
use App\Form\AnnoncesType;
use App\Form\CommentaireType;
use App\Form\CommentsType;
use App\Form\EditProfileType;
use App\Repository\AnnoncesRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ProjetRepository;
use App\Repository\UtilisateurRepository;
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
     * @Route("/profile", name="ProfileUtilisateur")
     */
    public function utilisateurProfil(UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateur = $utilisateurRepository->findby([]);

        return $this->render('utilisateur/profile.html.twig', [
            'utilisateur' => $utilisateur,
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
            $this->addFlash("success", "Votre commentaire a été ajouté avec succes");
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
            $this->addFlash("success", "Votre annonce a été ajoutée avec succes");
            return $this->redirectToRoute('main_annonces');
        }
        return $this->render('utilisateur/ajoutAnnonces.html.twig', [
            "form" => $form->createView(),
        ]);
    }
     /**
     * @Route("/comments", name="ajoutcomments")
     */
    public function comments(Request $request, EntityManagerInterface $entityManager,$slug, AnnoncesRepository $annoncesRepository): Response
    {
        // Partie commentaires
        // On crée le commentaire "vierge"
        $comment = new Comments();
        
        $annonce = $annoncesRepository->findOneBy(['slug' => $slug]);
         // On génère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);

        // Traitement du formulaire
        if ($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new DateTime());
            $comment->setAnnonces($annonce);

            
             // On récupère le contenu du champ parentid
             $parentid = $commentForm->get("parentid")->getData();

             // On va chercher le commentaire correspondant
             $entityManager = $this->getDoctrine()->getManager();
 
             if($parentid != null){
                 $parent = $entityManager->getRepository(Comments::class)->findBy($parentid);
             }
 
             // On définit le parent
             $comment->setParent($parent ?? null);
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash("success", "Votre commentaire a été ajouté avec succes");
            return $this->redirectToRoute('main_annonces',['slug' => $annonce->getSlug()]);
        }

        return $this->render('utilisateur/ajoutComments.html.twig', [
            'annonce' => $annonce,
            "comment" => $comment,
            "commentForm" => $commentForm->createView()
        ]);
    }
    // Ajout d'une annonces
    /**
     * @Route("/editProfile", name="editProfile")
     */
    public function editProfile(
    Request $request,
    EntityManagerInterface $entityManager): Response
{
    $utilisateur=$this->getUser();
$form = $this->createForm(EditProfileType::class, $utilisateur);
$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()){
$entityManager->persist($utilisateur);
$entityManager->flush();
$this->addFlash("success", "Votre profile a été modifié avec succès");
return $this->redirectToRoute('utilisateur_editProfile');
}
return $this->render('utilisateur/editprofile.html.twig', [
"Utilisateur" => $utilisateur,
"form" => $form->createView()
]);
}
}
