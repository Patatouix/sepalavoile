<?php

namespace App\DataFixtures;

use App\Entity\Creneau;
use App\Entity\Produit;
use App\Entity\ProduitType;
use App\Repository\ProduitTypeRepository;
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
        $produitEvent->setNom(ProduitType::PRODUIT_TYPE_EVENT_NAME);
        $produitEvent->setSlug(ProduitType::PRODUIT_TYPE_EVENT_SLUG);
        $manager->persist($produitEvent);

        $produitDon = new ProduitType();
        $produitDon->setNom(ProduitType::PRODUIT_TYPE_DONATION_NAME);
        $produitDon->setSlug(ProduitType::PRODUIT_TYPE_DONATION_SLUG);
        $manager->persist($produitDon);

        $produitAdhesion = new ProduitType();
        $produitAdhesion->setNom(ProduitType::PRODUIT_TYPE_ADHESION_NAME);
        $produitAdhesion->setSlug(ProduitType::PRODUIT_TYPE_ADHESION_SLUG);
        $manager->persist($produitAdhesion);

        //produits de type event

        for ($i = 1; $i <= 20; $i++) {
            $produit = new Produit();
            $produit->setNom('Event ' . $i);
            $produit->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
            $produit->setDebutPublication(new DateTime('2021-01-' . $i . ' 08:' . $i . ':30'));
            $produit->setFinPublication(new DateTime('2021-02-' . $i . ' 18:' . $i . ':50'));
            $produit->setAdresse($i . ' rue du Verboté');
            $produit->setCodePostal('90350');
            $produit->setVille('Belfort');
            $produit->setPrix($i);
            $produit->setObjectif($i + 5);
            $produit->setCreatedAt(new DateTime('NOW'));
            $produit->setProduitType($produitEvent);
            $manager->persist($produit);

            //4 creneaux par Event
            for ($j = 1; $j <= 4; $j++) {
                $creneau = new Creneau();
                $creneau->setProduit($produit);
                $creneau->setDebut(new DateTime('2021-01-' . $j . ' 08:' . $j . ':30'));
                $creneau->setFin(new DateTime('2021-01-' . $j . ' 18:' . $j . ':30'));
                $manager->persist($creneau);
            }
        }

        //produits de type don

        for ($i = 1; $i <= 5; $i++) {
            $produit = new Produit();
            $produit->setNom('Event ' . $i);
            $produit->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
            $produit->setDebutPublication(new DateTime('2021-01-' . $i . ' 08:' . $i . ':30'));
            $produit->setFinPublication(new DateTime('2021-02-' . $i . ' 18:' . $i . ':50'));
            $produit->setAdresse($i . ' rue du Verboté');
            $produit->setCodePostal('90350');
            $produit->setVille('Belfort');
            $produit->setPrix($i);
            $produit->setObjectif($i + 5);
            $produit->setCreatedAt(new DateTime('NOW'));
            $produit->setProduitType($produitDon);
            $manager->persist($produit);
        }

        //produits de type adhesion

        for ($i = 1; $i <= 5; $i++) {
            $produit = new Produit();
            $produit->setNom('Event ' . $i);
            $produit->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
            $produit->setDebutPublication(new DateTime('2021-01-' . $i . ' 08:' . $i . ':30'));
            $produit->setFinPublication(new DateTime('2021-02-' . $i . ' 18:' . $i . ':50'));
            $produit->setAdresse($i . ' rue du Verboté');
            $produit->setCodePostal('90350');
            $produit->setVille('Belfort');
            $produit->setPrix($i);
            $produit->setObjectif($i + 5);
            $produit->setCreatedAt(new DateTime('NOW'));
            $produit->setProduitType($produitAdhesion);
            $manager->persist($produit);
        }

        $manager->flush();
    }
}