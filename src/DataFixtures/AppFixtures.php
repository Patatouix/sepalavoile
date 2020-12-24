<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

//to run fixtures : symfony console doctrine:fixtures:load
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; $i++) {
            $produit = new Produit();
            $produit->setNom('Event '.$i);
            $produit->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
            $produit->setDateDebut(new DateTime('2021-01-' . $i . ' 10:' . $i . ':19'));
            $produit->setDateFin(new DateTime('2021-01-' . $i . ' 17:' . $i . ':25'));
            $produit->setAdresse($i . ' rue du Verboté');
            $produit->setCodePostal('90350');
            $produit->setVille('Belfort');
            $produit->setPrix($i);
            $produit->setObjectif($i + 5);
            $produit->setCreatedAt(new DateTime('NOW'));
            $manager->persist($produit);
        }

        $manager->flush();
    }
}