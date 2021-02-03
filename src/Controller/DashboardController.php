<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Article;
use App\Entity\Produit;
use App\Entity\ProduitType;
use App\Repository\AchatRepository;
use App\Repository\ArticleRepository;
use App\Repository\PartnersRepository;
use App\Repository\ProduitRepository;
use App\Repository\ProduitTypeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function index(AchatRepository $achatRepository, PartnersRepository $partnersRepository, UserRepository $userRepository, ArticleRepository $articleRepository, ProduitRepository $produitRepository, ProduitTypeRepository $produitTypeRepository): Response
    {
        $userByMonth = $userRepository->findByMonth();
        $produitByMonth = $produitRepository->findByMonth(ProduitType::PRODUIT_TYPE_ADHESION_SLUG);
        $articleBestView    = $this->getDoctrine()->getRepository(Article::class)->findBynombreVuDesc();
        // $achatRepository    = $this->getDoctrine()->getRepository(Achat::class)->findAll();
        // $produit            = $this->getDoctrine()->getRepository(Produit::class)->findBy(['']);
        // $media = $this->getDoctrine()->getRepository(Media::class)->findBy(['type' => 'video'], ['createdAt' => 'desc']);

        return $this->render('dashboard/index.html.twig', [
            'controller_name'       => 'DashboardController',
            'partners'           => $partnersRepository -> findAll(),
            // 'partners'           => $partnersRepository -> findBy([],['createdAt' => 'desc']),
            'articles'              => $articleRepository->findBy([],['createdAt' => 'desc']),
            'users'                 => $userRepository->findBy([],['createdAt' => 'desc']),
            'articleBestView'       => $articleBestView,
            'userByMonth'       => $userByMonth,
            // 'achats'                => $achatRepository,
            // 'produit'               => $produit,

        ]);
    }
}


// SELECT count(name),MONTH(created_at) as month 
// FROM `user` 
// GROUP BY MONTH
// ORDER BY MONTH(created_at)