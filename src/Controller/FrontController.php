<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(): Response
    {
        return $this->render('front/home_page.html.twig', [
            'controller_name' => 'FrontController',
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
    public function nospartenaires(): Response
    {
        return $this->render('front/nospartenaires.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
}
