<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleCategorieRepository;
use App\Repository\ArticleRepository;
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
    public function index(ArticleRepository $articleRepository, PartnersRepository $partnersRepository): Response
    {
        $articleBestView = $this->getDoctrine()->getRepository(Article::class)->findBynombreVuDesc();
        

        return $this->render('front/home_page.html.twig', [
            'controller_name' => 'FrontController',
            'articleBestView'   => $articleBestView,
            'article' => $articleRepository->findBy([],['createdAt' => 'desc']),
            'partners'          => $partnersRepository -> findAll(),
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
}
