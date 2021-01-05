<?php

namespace App\Controller;

use App\Entity\ArticleCategorie;
use App\Form\ArticleCategorieType;
use App\Repository\ArticleCategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article/categorie")
 */
class ArticleCategorieController extends AbstractController
{
    /**
     * @Route("/", name="article_categorie_index", methods={"GET"})
     */
    public function index(ArticleCategorieRepository $articleCategorieRepository): Response
    {
        return $this->render('article_categorie/index.html.twig', [
            'article_categories' => $articleCategorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_categorie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $articleCategorie = new ArticleCategorie();
        $form = $this->createForm(ArticleCategorieType::class, $articleCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articleCategorie);
            $entityManager->flush();

            return $this->redirectToRoute('article_categorie_index');
        }

        return $this->render('article_categorie/new.html.twig', [
            'article_categorie' => $articleCategorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_categorie_show", methods={"GET"})
     */
    public function show(ArticleCategorie $articleCategorie): Response
    {
        return $this->render('article_categorie/show.html.twig', [
            'article_categorie' => $articleCategorie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_categorie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ArticleCategorie $articleCategorie): Response
    {
        $form = $this->createForm(ArticleCategorieType::class, $articleCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_categorie_index');
        }

        return $this->render('article_categorie/edit.html.twig', [
            'article_categorie' => $articleCategorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_categorie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ArticleCategorie $articleCategorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleCategorie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($articleCategorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_categorie_index');
    }
}
