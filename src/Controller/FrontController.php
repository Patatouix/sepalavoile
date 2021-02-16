<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Media;
use App\Entity\MediaCategory;
use App\Repository\ArticleCategorieRepository;
use App\Repository\ArticleRepository;
use App\Repository\MediaCategoryRepository;
use App\Repository\MediaRepository;
use App\Repository\PartnersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(ArticleRepository $articleRepository, PartnersRepository $partnersRepository, MediaCategoryRepository $mediaCategoryRepository): Response
    {

        $articleBestView = $this->getDoctrine()->getRepository(Article::class)->findBynombreVuDesc();

        $mediaCategory = $mediaCategoryRepository->findBy(['name' => MediaCategory::MEDIA_CATEGORY_VIDEO_NAME]);
        $videoYt = $this->getDoctrine()->getRepository(Media::class)->findBy(['mediaCategory' => $mediaCategory], ['createdAt' => 'desc'], 3);
        $galerie = $this->getDoctrine()->getRepository(Media::class)->findBy(['type' => 'galerie'], ['createdAt' => 'desc']);

        return $this->render('front/home_page.html.twig', [
            'controller_name'   => 'FrontController',
            'articleBestView'   => $articleBestView,
            'article'           => $articleRepository->findBy([],['createdAt' => 'desc']),
            'partners'          => $partnersRepository -> findAll(),
            'videoYt'           => $videoYt,
            'galerie'           => $galerie,
        ]);
    }

    // @IsGranted("ROLE_ADMIN")
    // ou
    // /admin devant la route

    /**
     * @Route("/association", name="association")

     */
    public function association(): Response
    {
        return $this->render('front/association.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


    /**
     * @Route("/monhistoire", name="monhistoire")
     */
    public function monhistoire(): Response
    {
        return $this->render('front/monhistoire.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


    /**
     * @Route("/leprojet", name="leprojet")
     */
    public function leprojet(): Response
    {
        return $this->render('front/leprojet.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


    /**
     * @Route("/leparcours", name="leparcours")
     */
    public function leparcours(): Response
    {
        return $this->render('front/leparcours.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


    /**
     * @Route("/lequipe", name="lequipe")
     */
    public function lequipe(): Response
    {
        return $this->render('front/lequipe.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


    /**
     * @Route("/lebateau", name="lebateau")
     */
    public function lebateau(): Response
    {
        return $this->render('front/lebateau.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/galerie", name="galerie")
     */
    public function galerie(): Response
    {
        $galerie = $this->getDoctrine()->getRepository(Media::class)->findBy(['type' => 'galerie'], ['createdAt' => 'desc']);

        return $this->render('front/galerie.html.twig', [
            'controller_name' => 'FrontController',
            'galerie' => $galerie,
        ]);
    }


    /**
     * @Route("/onparledenous", name="onparledenous")
     */
    public function onparledenous(): Response
    {
        return $this->render('front/onparledenous.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }


    /**
     * @Route("/nospartenaires", name="nospartenaires")
     */
    public function nospartenaires(PartnersRepository $partnersRepository): Response
    {
        return $this->render('front/nospartenaires.html.twig', [
            'controller_name' => 'FrontController',
            'partners'          => $partnersRepository -> findAll(),
        ]);
    }


    public function carousel(MediaCategoryRepository $mediaCategoryRepository): Response
    {
        $mediaCategory = $mediaCategoryRepository->findBy(['name' => MediaCategory::MEDIA_CATEGORY_SLIDERPHOTO_NAME]);
        $sliderPhoto = $this->getDoctrine()->getRepository(Media::class)->findBy(['mediaCategory' => $mediaCategory], ['createdAt' => 'desc']);

        return $this->render('_include/carousel.html.twig', [
            'sliderPhoto' => $sliderPhoto,
        ]);
    }
}
