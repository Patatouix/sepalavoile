<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleCategorie;
use App\Form\ArticleType;
use App\Repository\ArticleCategorieRepository;
use App\Repository\ArticleRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/blog/{categoryId}", name="blog")
     */
    public function blog(ArticleRepository $articleRepository, Request $request, ArticleCategorieRepository $articleCategorieRepository, int $categoryId = null, PaginatorInterface $paginator): Response
    {
        // Permet d'afficher dans le ASIDE les articles avec le plus de vue
        $articleBestView = $this->getDoctrine()->getRepository(Article::class)->findBynombreVuDesc();
        // Permet d'afficher la liste des catégories
        $allCategory = $articleCategorieRepository -> findBy([],['name' => 'asc']);

        $articles = $articleRepository->findBy([],['createdAt' => 'desc']);

        //garder uniquement les articles qui correspondent à notre categorie dans l'url (car nuls en querybuilder)
        $articlesToKeep = [];
        if($categoryId ) {
            foreach ($articles as $article) {
                $categories = $article->getArticleCategories();
                foreach($categories as $categorie) {
                    if($categoryId == $categorie->getId()){
                        $articlesToKeep[] = $article;
                    }
                }
            };
        } else {
            $articlesToKeep = $articles;
        }

        // Permet de gerer la pagination dans les pages du blog
        $articles = $paginator->paginate(
            $articlesToKeep, /* query NOT result */
            $request->query->getInt('page', 1), /*numéro page par défaut*/
            4 /*limite d'article par page*/
        );

        // Permet d'afficher les articles catégories
        $categories = $articleCategorieRepository->findAll();
        // pour afficher dans le ASIDE le nombre complet d'article
        // sans tenir compte de la pagination
        $article = $articleRepository->findAll();
        
        return $this->render('article/blog.html.twig', [
            'articles'          => $articles,
            'category'          => $allCategory,
            'articleBestView'   => $articleBestView,
            'categories'        => $categories,
            'categoryId'        => $categoryId,
            'article'           => $article,

        ]);
    }


    /**
     * @Route("/article/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setCreatedAt( new DateTime('NOW'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article'   => $article,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article, ArticleRepository $articleRepository, Request $request, ArticleCategorieRepository $articleCategorieRepository): Response
    {

        $article->setNbVues($article->getNbVues() + 1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $articleBestView = $this->getDoctrine()->getRepository(Article::class)->findBynombreVuDesc();
        $allCategory = $articleCategorieRepository -> findBy([],['name' => 'asc']);

        $articles = $articleRepository -> findAll();
        $categories = $articleCategorieRepository -> findAll();

        $articleRandom = $articleRepository -> findBy([],['createdAt' => 'DESC']);

        return $this->render('article/show_article.html.twig', [
            'articles'          => $articleRepository->findBy([],['createdAt' => 'desc']),
            'category'          => $allCategory,
            'articleBestView'   => $articleBestView,
            'categories'        => $categories,
            'article'           => $article,
            'articleRandom'     => $articleRandom,
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setUpdatedAt( new DateTime('NOW'));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
