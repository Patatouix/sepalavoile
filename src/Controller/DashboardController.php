<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\PartnersRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function index(PartnersRepository $partnersRepository): Response
    {

        return $this->render('dashboard/index.html.twig', [
            'controller_name'   => 'DashboardController',
            'partners'          => $partnersRepository -> findAll(),

        ]);
    }
}
