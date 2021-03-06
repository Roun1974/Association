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
use App\Entity\Images;
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
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator

/**
 * @Route("/utilisateur", name="utilisateur_")
 */
class utilisateurController extends AbstractController
{
    // // liste l'ensemble des projets
    /**
     * @Route("/projet", name="listesProjet")
     */
    public function listesProjet(Request $request,PaginatorInterface $paginator,ProjetRepository $projetRepository): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Projet::class)->findAll();
        $projets = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );

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
     * @Route("/annonces", name="ajoutAnnonce", methods={"GET","POST"})
     */
    public function ajoutAnnonce(Request $request, EntityManagerInterface $entityManager): Response
    {
        $annonce = new Annonces();

        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $annonce->setUtilisateur($this->getUser());
            $annonce->setActive(false);
           // On récupère les images transmises
           $images = $form->get('images')->getData();
            // On boucle sur les images
            foreach($images as $image){
            // On génère un nouveau nom de fichier
            $fichier = md5(uniqid()) . '.' . $image->guessExtension();
            // On copie le fichier dans le dossier uploads
            $image->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            // On stocke l'image dans la base de données (son nom)
                $img = new Images();
                $img->setName($fichier);
                $annonce->addImage($img);
            }
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
    public function comments(Request $request, EntityManagerInterface $entityManager, AnnoncesRepository $annoncesRepository): Response
    {
        // Partie commentaires
        // On crée le commentaire "vierge"
        $comment = new Comments();
         // On génère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);
        // Traitement du formulaire
        if ($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatedAt(new DateTime());
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
            $this->addFlash("success", "Votre commentaire a été ajouté avec succes et sera soumise à une validation");
            return $this->redirectToRoute('main_annonces');
        }

        return $this->render('utilisateur/ajoutComments.html.twig', [
            
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
