<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Image;
use App\Entity\Projet;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Fixtures des Etats

        $etatEnCours = new Etat();
        $etatEnCours->setLibelle("En cours");
        $manager->persist($etatEnCours);

        $etatFutur = new Etat();
        $etatFutur->setLibelle("Futur");
        $manager->persist($etatFutur);

        $etatTermine = new Etat();
        $etatTermine->setLibelle("Terminé");
        $manager->persist($etatTermine);

        // Fixtures des projets terminés

        $sante = new Projet();
        $sante->setNom("La santé")
              ->setDescription("Dondou a bénéficié d'un projet de construction 
                                        poste de santé visant principalement à améliorer 
                                        la couverture sanitaire à Dondou et les villages environnants. 
                                        La qualité des soins offerte ne répond plus aux normes ni aux 
                                        besoins des populations usagères. L’enclavement de la zone oblige 
                                        les populations à parcourir plusieurs dizaines de kilomètres afin 
                                        d’effectuer un simple prélèvement sanguin..
                                        Depuis le 1 Septembre 2014,le nouveau poste de santé est fonctionnel 
                                        et équipé d'un matériel médical moderne")
                ->setEtat($etatTermine);
        $manager->persist($sante);

        $poste = new Projet();
        $poste->setNom("La poste")
            ->setDescription("Le bureau de poste de Dondou joue aujourd'hui un rôle important dans le 
                                        rapprochement de la population et son diaspora. Elle offre un service 
                                        impressionnant dans le paiement des mandats , des transferts électroniques 
                                        tels que Western Union , Money Express, Mandats express international, 
                                        Choice money transfert .il y'a aussi la distribution du courrier et 
                                        l'acheminement qui sont les métiers de bases de la poste.Le bureau de poste 
                                        de Dondou dispose d'un parc de 150 boîtes postales pour la sécurité et la 
                                        garanti des envois. La clientèle est composée d'immigrés en retraite,
                                        d'enseignants affectés dans le village et les commerçants (baol -baol).
                                        Elle est dotée de la nouvelle technologie qui permet non seulement un travail 
                                        de qualité mais aussi une ouverture envers le monde moderne. Actuellement la 
                                        poste dispose un réseau satellitaire qui lui est propre ,assurant : 
                                        une bonne connexion internet ,une communication sans rupture par le téléphone 
                                        fixe et l'interconnexions des bureaux de poste . Jadis le bureau de poste de 
                                        dondou connaissait beaucoup de problème en ce qui concerne la gestion ,
                                        l'accueil client et surtout le problème de liquidité .Aujourd'hui on note une 
                                        nette amé lioration dans tous les domaines .De nos jours la poste de Dondou 
                                        fait parti parmi les meilleures postes de la région de Matam grâce au volume 
                                        des transactions (western union et d'autres transferts) qui n'a cesse 
                                        d'augmenter d'une manière considérable .")
            ->setEtat($etatTermine);
        $manager->persist($poste);

        // // Fixtures des projets en cours

        $forage = new Projet();
        $forage->setNom("Le forage")
            ->setDescription("Dondou est traversé par le fleuve Sénégal qui joue un rôle important dans 
                                        la vie des populations.il a assuré pendant des années la consommation en 
                                        eau des populations. L’approvisionnement correct en eau potable est rendu 
                                        possible en 1987 par la volonté des ressortissants de Dondou en France 
                                        et la commune de Cléon en Seine Maritime. Le village de Dondou dispose 
                                        depuis les années 1986 d'un forage d'approvisionnement en eau potable. 
                                        Grâce aux émigrés et la ville de Cleon .Elle permet l'alimentation en 
                                        eau potable et l'assainissement - Un réseau potentiel d'adduction d'eau 
                                        et des branchements sociaux.On compte actuellement de 500 branchements.
                                        Le forage est géré avec un comité de gestion dont le président s'appelle 
                                        Ibrahima MBODJI.Gràce à l'ASIFOR il envisage procédé à l'extension des 
                                        brachement jusqu'à Gourel ndiawdy. La quasi-totalité des infrastructures 
                                        dont s'est doté le village proviennent des fonds des associations des 
                                        ressortissants de Dondou à l'étrangers.")
            ->setEtat($etatEnCours);
        $manager->persist($forage);

        // // Fixtures des images santé

        $imageSante1 = new Image();
        $imageSante1->setLibelle("poste de santé")
                    ->setCheminImage("gal9.jpg")
                    ->setProjet($sante);
        $manager->persist($imageSante1);

        $imageSante2 = new Image();
        $imageSante2->setLibelle("chambre de santé")
            ->setCheminImage("gal8.jpg")
            ->setProjet($sante);
        $manager->persist($imageSante2);

        $imageSante3 = new Image();
        $imageSante3->setLibelle("camion de santé")
            ->setCheminImage("gal6.jpg")
            ->setProjet($sante);
        $manager->persist($imageSante3);

        // Fixtures des images du forage

        $imageForage1 = new Image();
        $imageForage1->setLibelle("le forage")
            ->setCheminImage("forage.jpg")
            ->setProjet($forage);
        $manager->persist($imageForage1);

        // Fixtures des images de la page d'accueil

        $imageAgriculture = new Image();
        $imageAgriculture->setLibelle("Agriculture")
            ->setCheminImage("Agricule.jpg");
        $manager->persist($imageAgriculture);

        $imagePopulation = new Image();
        $imagePopulation->setLibelle("Population")
            ->setCheminImage("popilation.jpg");
        $manager->persist($imagePopulation);

        $imageGeographie = new Image();
        $imageGeographie->setLibelle("Position geographique")
            ->setCheminImage("Position geographique.jpg");
        $manager->persist($imageGeographie);

        $utilisateurAdmin = new Utilisateur();
        $utilisateurAdmin->setNom("admin")
                        ->setPrenom("admin")
                        ->setEmail("admin@admin.com")
                        ->setTelephone(0000000000)
                        ->setPassword("123456");
        $manager->persist($utilisateurAdmin);

        $manager->flush();
    }
}
