<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_accueil")
     */
    public function accueil(ProjetRepository $projetRepository,
                            ImageRepository $imageRepository): Response
    {
        $projetSante = $projetRepository->findBy(['id' => 8]);
        $projetPoste = $projetRepository->findBy(['id' => 9]);
        $projetForage = $projetRepository->findBy(['id' => 10]);
        $imageChambreSante = $imageRepository->findBy(['id' => 17]);
        $imageForage = $imageRepository->findBy(['id' => 19]);
        $imagesPositionGeographique = $imageRepository->findBy(['id' => 22]);
        $imagesPopulation = $imageRepository->findBy(['id' => 21]);
        $imagesEconomique = $imageRepository->findBy(['id' => 20]);
        $imageSante = $imageRepository->findAll();


        return $this->render('main/accueil.html.twig', [
            "projetSante" => $projetSante,
            "projetPoste" => $projetPoste,
            "projetForage" => $projetForage,
            "imageChambreSante" => $imageChambreSante,
            "imageForage" => $imageForage,
            "imagesPositionGeographique" => $imagesPositionGeographique,
            "imagesPopulation" => $imagesPopulation,
            "imagesEconomique" => $imagesEconomique,
            "imageSante" => $imageSante,
        ]);
    }

    /**
     * @Route("/termines", name="main_projetTermine")
     */
    public function projetTermine(ProjetRepository $projetRepository): Response
    {
        $projetTermines = $projetRepository->projetTermines();

        return $this->render('main/termines.html.twig',[
            "projetTermines" => $projetTermines
        ]);
    }

    /**
     * @Route("/enCours", name="main_projetEnCour")
     */
    public function projetEnCour(ProjetRepository $projetRepository): Response
    {
        $projetEnCours = $projetRepository->projetEnCour();

        return $this->render('main/enCours.html.twig',[
            "projetEnCours" => $projetEnCours
        ]);
    }

    /**
     * @Route("/Futur", name="main_projetFutur")
     */
    public function projetFuturs(ProjetRepository $projetRepository): Response
    {
        $projetFuturs = $projetRepository->projetFuturs();

        return $this->render('main/futurs.html.twig',[
            "projetFuturs" => $projetFuturs
        ]);

    }

}
