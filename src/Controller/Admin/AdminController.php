<?php

namespace App\Controller\Admin;

use App\Entity\Projet;
use App\Entity\Utilisateur;
use App\Form\ProjetType;
use App\Form\RegistrationFormType;
use App\Repository\ProjetRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */

class AdminController extends AbstractController
{
    // affichage de l'ensemble des projets
    /**
     * @Route("/projet", name="projet")
     */
    public function projet(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findAll();
        return $this->render('admin/admin/adminProjet.html.twig', [
            "projets" => $projets
        ]);
    }

    // Ajout d'un projet
    /**
     * @Route("/projet/ajout", name="ajoutProjet")
     */
    public function ajoutProjet(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($projet);
            $entityManager->flush();
            $this->addFlash("success", "L'ajout a été effectuée");
            return $this->redirectToRoute('admin_projet');
        }
        return $this->render('admin/admin/ajoutProjet.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    // Modification d'un projet
    /**
     * @Route("/projet/modification/{id}", name="modificationProjet")
     */
    public function modificationProjet(Projet $projet,
                                       Request $request,
                                       EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($projet);
            $entityManager->flush();
            $this->addFlash("success", "La modification a été effectuée");
            return $this->redirectToRoute('admin_projet');
        }
        return $this->render('admin/admin/modificationProjet.html.twig', [
            "projet" => $projet,
            "form" => $form->createView()
        ]);
    }

    // suppression d'un projet
    /**
     * @Route("/projet/suppression/{id}", name="suppressionProjet")
     */
    public function suppressionProjet(Projet $projet, Request $request, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($projet);
        $entityManager->flush();
        $this->addFlash("success", "La suppression a été effectuée");
        return $this->redirectToRoute('admin_projet');
    }


    // affiche l'ensemble des utilisateurs
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function utilisateur(UtilisateurRepository $utilisateurRepository): Response
    {
        $utilisateurs = $utilisateurRepository->findAll();
        return $this->render('admin/admin/adminUtilisateur.html.twig', [
            "utilisateurs" => $utilisateurs
        ]);
    }

    // modification des données d'un utilisateur
    /**
     * @Route("/adherent/modification/{id}", name="modificationUtilisateur")
     */
    public function modificationUtilisateur(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            $this->addFlash("success", "La modification a été effectuée");
            return $this->redirectToRoute("admin_utilisateur");
        }
        return $this->render('admin/admin/modificationUtilisateur.html.twig', [
            "utilisateur" => $utilisateur,
            "form" => $form->createView()
        ]);
    }


    // suppression d'un utilisateur
    /**
     * @Route("/adherent/suppression/{id}", name="suppressionUtilisateur")
     */
    public function suppressionUtilisateur(Utilisateur $utilisateur, Request $request, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($utilisateur);
        $entityManager->flush();
        $this->addFlash("success", "La suppression a été effectuée");
        return $this->redirectToRoute('admin_utilisateur');
    }
}