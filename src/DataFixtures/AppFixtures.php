<?php

namespace App\DataFixtures;

use App\Entity\Achat;
use App\Entity\Creneau;
use App\Entity\Media;
use App\Entity\Produit;
use App\Entity\ProduitType;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//to run fixtures : symfony console doctrine:fixtures:load
class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        //users
        $userAlbanAdmin = new User();
        $userAlbanAdmin->setEmail('alban-admin@gmail.com');
        $userAlbanAdmin->setRoles(['ROLE_ADMIN']);
        $userAlbanAdmin->setPassword($this->encoder->encodePassword($userAlbanAdmin, 'alban-admin'));
        $userAlbanAdmin->setName('jaillais');
        $userAlbanAdmin->setFirstname('alban');
        $userAlbanAdmin->setCreatedAt(new DateTime('NOW'));
        $userAlbanAdmin->setIsVerified(false);
        $manager->persist($userAlbanAdmin);

        $userAlbanUser = new User();
        $userAlbanUser->setEmail('alban-user@gmail.com');
        $userAlbanUser->setRoles(['ROLE_USER']);
        $userAlbanUser->setPassword($this->encoder->encodePassword($userAlbanUser, 'alban-user'));
        $userAlbanUser->setName('jaillais');
        $userAlbanUser->setFirstname('alban');
        $userAlbanUser->setCreatedAt(new DateTime('NOW'));
        $userAlbanUser->setIsVerified(false);
        $manager->persist($userAlbanUser);

        $userFabienAdmin = new User();
        $userFabienAdmin->setEmail('fabien-admin@gmail.com');
        $userFabienAdmin->setRoles(['ROLE_ADMIN']);
        $userFabienAdmin->setPassword($this->encoder->encodePassword($userFabienAdmin, 'fabien-admin'));
        $userFabienAdmin->setName('rohrbal');
        $userFabienAdmin->setFirstname('fabien');
        $userFabienAdmin->setCreatedAt(new DateTime('NOW'));
        $userFabienAdmin->setIsVerified(false);
        $manager->persist($userFabienAdmin);

        $userFabienUser = new User();
        $userFabienUser->setEmail('fabien-user@gmail.com');
        $userFabienUser->setRoles(['ROLE_USER']);
        $userFabienUser->setPassword($this->encoder->encodePassword($userFabienUser, 'fabien-user'));
        $userFabienUser->setName('rohrbal');
        $userFabienUser->setFirstname('fabien');
        $userFabienUser->setCreatedAt(new DateTime('NOW'));
        $userFabienUser->setIsVerified(false);
        $manager->persist($userFabienUser);

        $userCharlesAdmin = new User();
        $userCharlesAdmin->setEmail('charles-admin@gmail.com');
        $userCharlesAdmin->setRoles(['ROLE_ADMIN']);
        $userCharlesAdmin->setPassword($this->encoder->encodePassword($userCharlesAdmin, 'charles-admin'));
        $userCharlesAdmin->setName('anguenot');
        $userCharlesAdmin->setFirstname('charles');
        $userCharlesAdmin->setCreatedAt(new DateTime('NOW'));
        $userCharlesAdmin->setIsVerified(false);
        $manager->persist($userCharlesAdmin);

        $userCharlesUser = new User();
        $userCharlesUser->setEmail('charles-user@gmail.com');
        $userCharlesUser->setRoles(['ROLE_USER']);
        $userCharlesUser->setPassword($this->encoder->encodePassword($userCharlesUser, 'charles-user'));
        $userCharlesUser->setName('anguenot');
        $userCharlesUser->setFirstname('charles');
        $userCharlesUser->setCreatedAt(new DateTime('NOW'));
        $userCharlesUser->setIsVerified(false);
        $manager->persist($userCharlesUser);

        $userArray = [$userAlbanAdmin, $userAlbanUser, $userFabienAdmin, $userFabienUser, $userCharlesAdmin, $userCharlesUser];

        for ($i = 1; $i <= 20; $i++) {
            $user = new User();
            $user->setEmail('user' . $i .'@gmail.com');
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->encoder->encodePassword($user, 'user' . $i));
            $user->setName('nom' . $i);
            $user->setFirstname('prenom' . $i);
            $user->setCreatedAt(new DateTime('NOW'));
            $user->setIsVerified(false);
            $manager->persist($user);
        }

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

        // medias
        $media = new Media();
        $media->setCreatedAt(new DateTime('NOW'));
        $media->setNom('default-placeholder.png');
        $media->setUrl('https://www.événementiel.net/wp-content/uploads/2014/02/default-placeholder.png');
        $media->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
        $media->setTitre('Image par défaut pour nos entités');
        $manager->persist($media);

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
            $produit->setObjectif($i + 2);
            $produit->setCreatedAt(new DateTime('NOW'));
            $produit->addMedia($media);
            $produit->setProduitType($produitEvent);
            $manager->persist($produit);

            //4 creneaux par Event
            for ($j = 1; $j <= 4; $j++) {
                $creneau = new Creneau();
                $creneau->setProduit($produit);
                $creneau->setDebut(new DateTime('2021-01-' . $j . ' 08:' . $j . ':30'));
                $creneau->setFin(new DateTime('2021-01-' . $j . ' 18:' . $j . ':30'));
                $manager->persist($creneau);

                for ($k = 1; $k <= 3; $k++) {
                    $achat = new Achat();
                    $achat->setProduit($produit);
                    $achat->setCreneau($creneau);
                    $achat->setCreatedAt(new DateTime('NOW'));
                    $achat->setMontant($k);
                    $achat->setQuantite(1);
                    $achat->setUser($userArray[array_rand($userArray)]);
                    $manager->persist($achat);
                }
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
            $produit->addMedia($media);
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
            $produit->addMedia($media);
            $produit->setProduitType($produitAdhesion);
            $manager->persist($produit);
        }

        $manager->flush();
    }
}