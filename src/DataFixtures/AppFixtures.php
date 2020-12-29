<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\ProduitType;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

//to run fixtures : symfony console doctrine:fixtures:load
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //produitTypes
        $produitEvent = new ProduitType();
        $produitEvent->setNom('Evénement');
        $manager->persist($produitEvent);

        $produitDon = new ProduitType();
        $produitDon->setNom('Donation');
        $manager->persist($produitDon);

        $produitAdhesion = new ProduitType();
        $produitAdhesion->setNom('Adhésion');
        $manager->persist($produitAdhesion);

        //produits

        //events
        for ($i = 1; $i <= 5; $i++) {
            //même event, mais avec des dates différentes
            for ($j = 1; $j <= 5; $j++) {
                $produit = new Produit();
                $produit->setNom('Event ' . $i);
                $produit->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
                $produit->setDateDebut(new DateTime('2021-01-' . $j . ' 10:' . $j . ':19'));
                $produit->setDateFin(new DateTime('2021-01-' . $j . ' 17:' . $j . ':25'));
                $produit->setAdresse($i . ' rue du Verboté');
                $produit->setCodePostal('90350');
                $produit->setVille('Belfort');
                $produit->setPrix($i);
                $produit->setObjectif($i + 5);
                $produit->setCreatedAt(new DateTime('NOW'));
                $produit->setProduitType($produitEvent);
                $manager->persist($produit);
            }
        }

        $manager->flush();
    }
}