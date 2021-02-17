<?php

namespace App\DataFixtures;

use App\Entity\Achat;
use App\Entity\Article;
use App\Entity\ArticleCategorie;
use App\Entity\Commentaire;
use App\Entity\Creneau;
use App\Entity\Media;
use App\Entity\MediaCategory;
use App\Entity\Message;
use App\Entity\Partners;
use App\Entity\Produit;
use App\Entity\ProduitType;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Sondage;
use App\Entity\Reservation;
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
        $userAlbanUser->setCreatedAt(new DateTime('2021-05-31 00:00:30'));
        $userAlbanUser->setIsVerified(false);
        $manager->persist($userAlbanUser);

        $userFabienAdmin = new User();
        $userFabienAdmin->setEmail('fabien-admin@gmail.com');
        $userFabienAdmin->setRoles(['ROLE_ADMIN']);
        $userFabienAdmin->setPassword($this->encoder->encodePassword($userFabienAdmin, 'fabien-admin'));
        $userFabienAdmin->setName('rohrbal');
        $userFabienAdmin->setFirstname('fabien');
        $userFabienAdmin->setCreatedAt(new DateTime('2021-09-18 00:00:01'));
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

        for ($i = 1; $i <= 12; $i++) {
            $user = new User();
            $user->setEmail('user' . $i .'@gmail.com');
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->encoder->encodePassword($user, 'user' . $i));
            $user->setName('nom' . $i);
            $user->setFirstname('prenom' . $i);
            $user->setCreatedAt(new DateTime('2021-' . $i . '-' . $i . ' 18:' . $i . ':50'));
            $user->setIsVerified(false);
            $manager->persist($user);
        }

        //messages
        for ($i = 1; $i <= 50; $i++) {
            $msg = new Message();
            $msg->setObjet('Objet ' . $i);
            $msg->setContenu('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
            $msg->setCreatedAt(new DateTime('NOW'));
            $msg->setExpediteur($userArray[array_rand($userArray)]);
            $msg->setDestinataire($userArray[array_rand($userArray)]);
            $manager->persist($msg);
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


        //mediaCategory
        $mediaCategoryImage = new MediaCategory();
        $mediaCategoryImage->setName(MediaCategory::MEDIA_CATEGORY_IMAGE_NAME);
        $manager->persist($mediaCategoryImage);

        $mediaCategoryVideo = new MediaCategory();
        $mediaCategoryVideo->setName(MediaCategory::MEDIA_CATEGORY_VIDEO_NAME);
        $manager->persist($mediaCategoryVideo);

        $mediaCategorySliderPhoto = new MediaCategory();
        $mediaCategorySliderPhoto->setName(MediaCategory::MEDIA_CATEGORY_SLIDERPHOTO_NAME);
        $manager->persist($mediaCategorySliderPhoto);

        $mediaCategoryHeaderVideo = new MediaCategory();
        $mediaCategoryHeaderVideo->setName(MediaCategory::MEDIA_CATEGORY_HEADERVIDEO_NAME);
        $manager->persist($mediaCategoryHeaderVideo);

        $mediaCategoryFichier = new MediaCategory();
        $mediaCategoryFichier->setName(MediaCategory::MEDIA_CATEGORY_FICHIER_NAME);
        $manager->persist($mediaCategoryFichier);

        // medias
        $media = new Media();
        $media->setCreatedAt(new DateTime('NOW'));
        $media->setNom('default-placeholder.png');
        $media->setUrl('https://www.événementiel.net/wp-content/uploads/2014/02/default-placeholder.png');
        $media->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
        $media->setTitre('Image par défaut pour nos entités');
        $media->setMediaCategory($mediaCategoryImage);
        $manager->persist($media);

        $mediaAiragri = new Media();
        $mediaAiragri->setCreatedAt(new DateTime('NOW'));
        $mediaAiragri->setNom('sponsor-airagri.jpg');
        $mediaAiragri->setUrl('http://www.sas-airagri.com/');
        $mediaAiragri->setDescription('AIRAGRI');
        $mediaAiragri->setTitre('AIRAGRI');
        $mediaAiragri->setMediaCategory($mediaCategoryImage);
        $manager->persist($mediaAiragri);

        $mediaPicvert = new Media();
        $mediaPicvert->setCreatedAt(new DateTime('NOW'));
        $mediaPicvert->setNom('sponsor-picvert.jpg');
        $mediaPicvert->setUrl('https://www.picvert.com/');
        $mediaPicvert->setDescription('PICVERT');
        $mediaPicvert->setTitre('PICVERT');
        $mediaPicvert->setMediaCategory($mediaCategoryImage);
        $manager->persist($mediaPicvert);

        $mediaDivatec = new Media();
        $mediaDivatec->setCreatedAt(new DateTime('NOW'));
        $mediaDivatec->setNom('sponsor-divatec.jpg');
        $mediaDivatec->setUrl('https://www.divatec.eu/');
        $mediaDivatec->setDescription('DIVATEC');
        $mediaDivatec->setTitre('DIVATEC');
        $mediaDivatec->setMediaCategory($mediaCategoryImage);
        $manager->persist($mediaDivatec);

        $mediaDalmard = new Media();
        $mediaDalmard->setCreatedAt(new DateTime('NOW'));
        $mediaDalmard->setNom('sponsor-dalmard.jpg');
        $mediaDalmard->setUrl('https://www.dalmardmarine.com/');
        $mediaDalmard->setDescription('DALMARD MARINE');
        $mediaDalmard->setTitre('DALMARD MARINE');
        $mediaDalmard->setMediaCategory($mediaCategoryImage);
        $manager->persist($mediaDalmard);

        $mediaIej = new Media();
        $mediaIej->setCreatedAt(new DateTime('NOW'));
        $mediaIej->setNom('sponsor-iej.jpg');
        $mediaIej->setUrl('https://iej.eu/strasbourg/');
        $mediaIej->setDescription('IEJ');
        $mediaIej->setTitre('IEJ');
        $mediaIej->setMediaCategory($mediaCategoryImage);
        $manager->persist($mediaIej);

        $mediaVieuxCampeur = new Media();
        $mediaVieuxCampeur->setCreatedAt(new DateTime('NOW'));
        $mediaVieuxCampeur->setNom('sponsor-vieuxcampeur.jpg');
        $mediaVieuxCampeur->setUrl('https://www.auvieuxcampeur.fr/');
        $mediaVieuxCampeur->setDescription('AUX VIEUX CAMPEUR');
        $mediaVieuxCampeur->setTitre('AUX VIEUX CAMPEUR');
        $mediaVieuxCampeur->setMediaCategory($mediaCategoryImage);
        $manager->persist($mediaVieuxCampeur);

        $mediaAcal = new Media();
        $mediaAcal->setCreatedAt(new DateTime('NOW'));
        $mediaAcal->setNom('sponsor-acal.jpg');
        $mediaAcal->setUrl('http://www.acal67.com/voile-acal-strasbourg/');
        $mediaAcal->setDescription('ACAL');
        $mediaAcal->setTitre('ACAL');
        $mediaAcal->setMediaCategory($mediaCategoryImage);
        $manager->persist($mediaAcal);

        // MEDIA TYPE YOUTUBE
        $mediaYoutube1 = new Media();
        $mediaYoutube1->setCreatedAt(new DateTime('NOW'));
        $mediaYoutube1->setNom('couv-vlog3.jpg');
        $mediaYoutube1->setUrl('https://www.youtube.com/embed/lAxDV7KQV6I');
        $mediaYoutube1->setDescription('Navigations 2019');
        $mediaYoutube1->setTitre('Navigations 2019');
        $mediaYoutube1->setFacebookLink('https://www.facebook.com/dialog/share?app_id=87741124305&href=https%3A//www.youtube.com/watch%3Fv%3DpwMJ_hzBp8M%26feature%3Demb_share&display=popup');
        $mediaYoutube1->setMediaCategory($mediaCategoryVideo);
        $mediaYoutube1->setIsDisplayed(true);
        $manager->persist($mediaYoutube1);

        $mediaYoutube2 = new Media();
        $mediaYoutube2->setCreatedAt(new DateTime('NOW'));
        $mediaYoutube2->setNom('couv-vlog2.jpg');
        $mediaYoutube2->setUrl('https://www.youtube.com/embed/W8BpET1Juhk');
        $mediaYoutube2->setDescription('Remontée du bateau, Porto - La Vendée');
        $mediaYoutube2->setTitre('Remontée du bateau, Porto - La Vendée');
        $mediaYoutube2->setFacebookLink('https://www.facebook.com/dialog/share?app_id=87741124305&href=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DW8BpET1Juhk%26feature%3Demb_share&display=popup');
        $mediaYoutube2->setMediaCategory($mediaCategoryVideo);
        $mediaYoutube2->setIsDisplayed(true);
        $manager->persist($mediaYoutube2);

        $mediaYoutube3 = new Media();
        $mediaYoutube3->setCreatedAt(new DateTime('NOW'));
        $mediaYoutube3->setNom('couv-vlog1.jpg');
        $mediaYoutube3->setUrl('https://www.youtube.com/embed/pwMJ_hzBp8M');
        $mediaYoutube3->setDescription('Découverte du bateau par l\'équipe projet');
        $mediaYoutube3->setTitre('Découverte du bateau par l\'équipe projet');
        $mediaYoutube3->setFacebookLink('https://www.facebook.com/dialog/share?app_id=87741124305&href=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DlAxDV7KQV6I%26feature%3Demb_share&display=popup');
        $mediaYoutube3->setMediaCategory($mediaCategoryVideo);
        $mediaYoutube3->setIsDisplayed(true);
        $manager->persist($mediaYoutube3);

        //MEDIA TYPE SLIDER HEADER PHOTO
        $sliderHeaderPhoto1 = new Media();
        $sliderHeaderPhoto1->setCreatedAt(new DateTime('NOW'));
        $sliderHeaderPhoto1->setNom('bg-slide-1.jpg');
        $sliderHeaderPhoto1->setDescription('slider bg 1');
        $sliderHeaderPhoto1->setTitre('slider bg 1');
        $sliderHeaderPhoto1->setMediaCategory($mediaCategorySliderPhoto);
        $sliderHeaderPhoto1->setIsDisplayed(true);
        $manager->persist($sliderHeaderPhoto1);

        $sliderHeaderPhoto2 = new Media();
        $sliderHeaderPhoto2->setCreatedAt(new DateTime('NOW'));
        $sliderHeaderPhoto2->setNom('bg-slide-2.jpg');
        $sliderHeaderPhoto2->setDescription('slider bg 2');
        $sliderHeaderPhoto2->setTitre('slider bg 2');
        $sliderHeaderPhoto2->setMediaCategory($mediaCategorySliderPhoto);
        $sliderHeaderPhoto2->setIsDisplayed(true);
        $manager->persist($sliderHeaderPhoto2);

        $sliderHeaderPhoto3 = new Media();
        $sliderHeaderPhoto3->setCreatedAt(new DateTime('NOW'));
        $sliderHeaderPhoto3->setNom('bg-slide-3.jpg');
        $sliderHeaderPhoto3->setDescription('slider bg 3');
        $sliderHeaderPhoto3->setTitre('slider bg 3');
        $sliderHeaderPhoto3->setMediaCategory($mediaCategorySliderPhoto);
        $sliderHeaderPhoto3->setIsDisplayed(true);
        $manager->persist($sliderHeaderPhoto3);

        //MEDIA TYPE HEADER VIDEO

        $headerVideo = new Media();
        $headerVideo->setCreatedAt(new DateTime('NOW'));
        $headerVideo->setNom('video-site-internet-projet-web.mov');
        $headerVideo->setDescription('header video');
        $headerVideo->setTitre('header video');
        $headerVideo->setMediaCategory($mediaCategoryHeaderVideo);
        $headerVideo->setIsDisplayed(true);
        $manager->persist($headerVideo);

        //Galerie
        $mediaGalerie1 = new Media();
        $mediaGalerie1->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie1->setNom('paysage-2.jpg');
        $mediaGalerie1->setUrl('');
        $mediaGalerie1->setDescription('paysage-2.jpg');
        $mediaGalerie1->setTitre('');
        $mediaGalerie1->setFacebookLink('');
        $mediaGalerie1->setType('galerie');
        $manager->persist($mediaGalerie1);

        $mediaGalerie2 = new Media();
        $mediaGalerie2->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie2->setNom('paysage-3.jpg');
        $mediaGalerie2->setUrl('');
        $mediaGalerie2->setDescription('paysage-3.jpg');
        $mediaGalerie2->setTitre('');
        $mediaGalerie2->setFacebookLink('');
        $mediaGalerie2->setType('galerie');
        $manager->persist($mediaGalerie2);

        $mediaGalerie3 = new Media();
        $mediaGalerie3->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie3->setNom('paysage-6.jpg');
        $mediaGalerie3->setUrl('');
        $mediaGalerie3->setDescription('paysage-6.jpg');
        $mediaGalerie3->setTitre('');
        $mediaGalerie3->setFacebookLink('');
        $mediaGalerie3->setType('galerie');
        $manager->persist($mediaGalerie3);

        $mediaGalerie3 = new Media();
        $mediaGalerie3->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie3->setNom('paysage-21.jpg');
        $mediaGalerie3->setUrl('');
        $mediaGalerie3->setDescription('paysage-21.jpg');
        $mediaGalerie3->setTitre('');
        $mediaGalerie3->setFacebookLink('');
        $mediaGalerie3->setType('galerie');
        $manager->persist($mediaGalerie3);

        $mediaGalerie4 = new Media();
        $mediaGalerie4->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie4->setNom('paysage-8.jpg');
        $mediaGalerie4->setUrl('');
        $mediaGalerie4->setDescription('paysage-8.jpg');
        $mediaGalerie4->setTitre('');
        $mediaGalerie4->setFacebookLink('');
        $mediaGalerie4->setType('galerie');
        $manager->persist($mediaGalerie4);

        $mediaGalerie5 = new Media();
        $mediaGalerie5->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie5->setNom('paysage-9.jpg');
        $mediaGalerie5->setUrl('');
        $mediaGalerie5->setDescription('paysage-9.jpg');
        $mediaGalerie5->setTitre('');
        $mediaGalerie5->setFacebookLink('');
        $mediaGalerie5->setType('galerie');
        $manager->persist($mediaGalerie5);

        $mediaGalerie6 = new Media();
        $mediaGalerie6->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie6->setNom('paysage-10.jpg');
        $mediaGalerie6->setUrl('');
        $mediaGalerie6->setDescription('paysage-10.jpg');
        $mediaGalerie6->setTitre('');
        $mediaGalerie6->setFacebookLink('');
        $mediaGalerie6->setType('galerie');
        $manager->persist($mediaGalerie6);

        $mediaGalerie7 = new Media();
        $mediaGalerie7->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie7->setNom('paysage-11.jpg');
        $mediaGalerie7->setUrl('');
        $mediaGalerie7->setDescription('paysage-11.jpg');
        $mediaGalerie7->setTitre('');
        $mediaGalerie7->setFacebookLink('');
        $mediaGalerie7->setType('galerie');
        $manager->persist($mediaGalerie7);

        $mediaGalerie8 = new Media();
        $mediaGalerie8->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie8->setNom('paysage-13.jpg');
        $mediaGalerie8->setUrl('');
        $mediaGalerie8->setDescription('paysage-13.jpg');
        $mediaGalerie8->setTitre('');
        $mediaGalerie8->setFacebookLink('');
        $mediaGalerie8->setType('galerie');
        $manager->persist($mediaGalerie8);

        $mediaGalerie9 = new Media();
        $mediaGalerie9->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie9->setNom('paysage-16.jpg');
        $mediaGalerie9->setUrl('');
        $mediaGalerie9->setDescription('paysage-16.jpg');
        $mediaGalerie9->setTitre('');
        $mediaGalerie9->setFacebookLink('');
        $mediaGalerie9->setType('galerie');
        $manager->persist($mediaGalerie9);

        $mediaGalerie10 = new Media();
        $mediaGalerie10->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie10->setNom('paysage-18.jpg');
        $mediaGalerie10->setUrl('');
        $mediaGalerie10->setDescription('paysage-18.jpg');
        $mediaGalerie10->setTitre('');
        $mediaGalerie10->setFacebookLink('');
        $mediaGalerie10->setType('galerie');
        $manager->persist($mediaGalerie10);

        $mediaGalerie11 = new Media();
        $mediaGalerie11->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie11->setNom('paysage-21.jpg');
        $mediaGalerie11->setUrl('');
        $mediaGalerie11->setDescription('paysage-21.jpg');
        $mediaGalerie11->setTitre('');
        $mediaGalerie11->setFacebookLink('');
        $mediaGalerie11->setType('galerie');
        $manager->persist($mediaGalerie11);

        $mediaGalerie12 = new Media();
        $mediaGalerie12->setCreatedAt(new DateTime('NOW'));
        $mediaGalerie12->setNom('paysage-27.jpg');
        $mediaGalerie12->setUrl('');
        $mediaGalerie12->setDescription('paysage-27.jpg');
        $mediaGalerie12->setTitre('');
        $mediaGalerie12->setFacebookLink('');
        $mediaGalerie12->setType('galerie');
        $manager->persist($mediaGalerie12);


        // Les Partenaires
        $partnersAiragri = new Partners();
        $partnersAiragri->setName('AIRAGRI');
        $partnersAiragri->setWebSite('http://alban-dev-online.ovh/');
        $partnersAiragri->setMedia($mediaAiragri);
        $manager->persist($partnersAiragri);

        $partnersPicvert = new Partners();
        $partnersPicvert->setName('PICVERT');
        $partnersPicvert->setWebSite('https://picvert.com');
        $partnersPicvert->setMedia($mediaPicvert);
        $manager->persist($partnersPicvert);

        $partnersDivatec = new Partners();
        $partnersDivatec->setName('DIVATEC');
        $partnersDivatec->setWebSite('https://www.divatec.eu/');
        $partnersDivatec->setMedia($mediaDivatec);
        $manager->persist($partnersDivatec);

        $partnersDalmard = new Partners();
        $partnersDalmard->setName('DALMARD MARINE');
        $partnersDalmard->setWebSite('https://www.dalmardmarine.com/');
        $partnersDalmard->setMedia($mediaDalmard);
        $manager->persist($partnersDalmard);

        $partnersIej = new Partners();
        $partnersIej->setName('IEJ');
        $partnersIej->setWebSite('https://iej.eu/strasbourg/');
        $partnersIej->setMedia($mediaIej);
        $manager->persist($partnersIej);

        $partnersmediaVieuxCampeur = new Partners();
        $partnersmediaVieuxCampeur->setName('AU VIEUX CAMPEUR');
        $partnersmediaVieuxCampeur->setWebSite('https://www.auvieuxcampeur.fr/');
        $partnersmediaVieuxCampeur->setMedia($mediaVieuxCampeur);
        $manager->persist($partnersmediaVieuxCampeur);

        $partnersAcal = new Partners();
        $partnersAcal->setName('ACAL');
        $partnersAcal->setWebSite('http://www.acal67.com/voile-acal-strasbourg/');
        $partnersAcal->setMedia($mediaAcal);
        $manager->persist($partnersAcal);

        //Catégorie d'Articles
        for ($i = 1; $i <= 5; $i++) {
            $categorie = new ArticleCategorie();
            $categorie->setName('Categorie' . $i);
            $manager->persist($categorie);

            //articles
            for ($j = 1; $j <= 5; $j++) {
                $article = new Article();
                $article->setTitle('title' . $j);
                $article->setContent('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
                $article->setAuthor('Author' . $j);
                $article->setCreatedAt(new DateTime('NOW'));
                $article->setIsPublished(true);
                $article->addArticleCategory($categorie);
                $manager->persist($article);

                //commentaires
                for ($k = 1; $k <= 3; $k++) {
                    $commentaire = new Commentaire();
                    $commentaire->setContenu('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
                    $commentaire->setIsPublished(rand(0,1) == 1);
                    $commentaire->setCreatedAt(new DateTime('NOW'));
                    $commentaire->setUpdatedAt(new DateTime('NOW'));
                    $commentaire->setArticle($article);
                    $commentaire->setUser($userArray[array_rand($userArray)]);
                    $manager->persist($commentaire);
                }
            }
        }

        //produits de type event
        for ($i = 1; $i <= 20; $i++) {
            $produit = new Produit();
            $produit->setNom('Event ' . $i);
            $produit->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
            $produit->setDebutVente(new DateTime('2021-01-' . $i . ' 08:' . $i . ':30'));
            $produit->setFinVente(new DateTime('2021-02-' . $i . ' 18:' . $i . ':50'));
            $produit->setAdresse($i . ' rue du Verboté');
            $produit->setCodePostal('90350');
            $produit->setVille('Belfort');
            $produit->setPrix($i);
            $produit->setLimiteParticipation($i + 5);
            $produit->setCreatedAt(new DateTime('NOW'));
            $produit->addMedia($media);
            $produit->setProduitType($produitEvent);
            $manager->persist($produit);

            //4 creneaux par Event
            for ($j = 1; $j <= 4; $j++) {
                $creneau = new Creneau();
                $creneau->setProduit($produit);
                $creneau->setDebut(new DateTime('2021-02-' . ($j + 10). ' 08:' . $j . ':30'));
                $creneau->setFin(new DateTime('2021-02-' . ($j + 10). ' 18:' . $j . ':30'));
                $manager->persist($creneau);

                //réservations
                for ($k = 1; $k <= 3; $k++) {
                    $reservation = new Reservation();
                    $reservation->setCreneau($creneau);
                    $reservation->setCreatedAt(new DateTime('NOW'));
                    $reservation->setPrixPaye($i);
                    $reservation->setQuantitePlaces($k);
                    $reservation->setUser($userArray[array_rand($userArray)]);
                    $manager->persist($reservation);
                }
            }
        }

        //produits de type don
        for ($i = 1; $i <= 5; $i++) {
            $produit = new Produit();
            $produit->setNom('Campagne de don ' . $i);
            $produit->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
            $produit->setDebutVente(new DateTime('2021-01-' . $i . ' 08:' . $i . ':30'));
            $produit->setFinVente(new DateTime('2021-02-' . $i . ' 18:' . $i . ':50'));
            $produit->setAdresse($i . ' rue du Verboté');
            $produit->setCodePostal('90350');
            $produit->setVille('Belfort');
            $produit->setPrix($i);
            $produit->setLimiteParticipation($i + 100);
            $produit->setCreatedAt(new DateTime('NOW'));
            $produit->addMedia($media);
            $produit->setProduitType($produitDon);
            $manager->persist($produit);

            //donations
            for ($k = 1; $k <= 3; $k++) {
                $achat = new Achat();
                $achat->setProduit($produit);
                $achat->setCreatedAt(new DateTime('NOW'));
                $achat->setPrixPaye($i + $k);
                $achat->setUser($userArray[array_rand($userArray)]);
                $manager->persist($achat);
            }
        }

        //produits de type adhesion
        for ($i = 1; $i <= 5; $i++) {
            $produit = new Produit();
            $produit->setNom('Campagne d\'adhésion ' . $i);
            $produit->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?<br><br>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
            $produit->setDebutVente(new DateTime('2021-01-' . $i . ' 08:' . $i . ':30'));
            $produit->setFinVente(new DateTime('2021-02-' . $i . ' 18:' . $i . ':50'));
            $produit->setAdresse($i . ' rue du Verboté');
            $produit->setCodePostal('90350');
            $produit->setVille('Belfort');
            $produit->setPrix($i);
            $produit->setDuree($i);
            $produit->setLimiteParticipation($i + 5);
            $produit->setCreatedAt(new DateTime('NOW'));
            $produit->addMedia($media);
            $produit->setProduitType($produitAdhesion);
            $manager->persist($produit);

            //adhesions
            for ($k = 1; $k <= 3; $k++) {
                $achat = new Achat();
                $achat->setProduit($produit);
                $achat->setCreatedAt(new DateTime('NOW'));
                $achat->setPrixPaye($i + $k);
                $achat->setUser($userArray[array_rand($userArray)]);
                $manager->persist($achat);
            }
        }

        for($i = 1; $i <= 10; $i++){
            $sondage = new Sondage();
            $sondage->setTitre('Titre' . $i);
            $sondage->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat aperiam doloremque, dolores voluptates obcaecati nihil ipsam voluptatibus vero exercitationem in, debitis sapiente. Alias ullam culpa sint vel esse, numquam in?');
            $sondage->setCreatedAt(new DateTime('NOW'));
            $manager->persist($sondage);

            for($o = 1; $o <= 5; $o++){
                $question = new Question();
                $question->setLabel('Question' . $o);
                $question->setSondage($sondage);
                $question->setHelp('Aide pour repondre à la question');
                $manager->persist($question);

                for($u = 1; $u <= 3;$u++){
                    $reponse = new Reponse();
                    $reponse->setContenu('Lorem ipsum dolor sit amet consectetur adipisicing elit.s vero exercitationem in, debitis sapiente.in?');
                    $reponse->setQuestion($question);
                    $userIndex = array_rand($userArray);
                    $user = $userArray[$userIndex];
                    $reponse->setUser($user);
                    unset($userArray[$userIndex]);
                    $manager->persist($reponse);
                }
                $userArray = [$userAlbanAdmin, $userAlbanUser, $userFabienAdmin, $userFabienUser, $userCharlesAdmin, $userCharlesUser];
            }
        }


        $manager->flush();
    }
}