<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Commentaire;

class CommentairesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $a = new Commentaire();
        $manager->flush();
    }
}
