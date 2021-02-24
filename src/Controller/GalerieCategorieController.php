<?php

namespace App\Controller;

use App\Entity\GalerieCategorie;
use App\Form\GalerieCategorieType;
use App\Repository\GalerieCategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/galerie/categorie")
 */
class GalerieCategorieController extends AbstractController
{
    /**
     * @Route("/", name="galerie_categorie_index", methods={"GET"})
     */
    public function index(GalerieCategorieRepository $galerieCategorieRepository): Response
    {
        return $this->render('galerie_categorie/index.html.twig', [
            'galerie_categories' => $galerieCategorieRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="galerie_categorie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $galerieCategorie = new GalerieCategorie();
        $form = $this->createForm(GalerieCategorieType::class, $galerieCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($galerieCategorie);
            $entityManager->flush();

            return $this->redirectToRoute('galerie_categorie_index');
        }

        return $this->render('galerie_categorie/new.html.twig', [
            'galerie_categorie' => $galerieCategorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="galerie_categorie_show", methods={"GET"})
     */
    public function show(GalerieCategorie $galerieCategorie): Response
    {
        return $this->render('galerie_categorie/show.html.twig', [
            'galerie_categorie' => $galerieCategorie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="galerie_categorie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GalerieCategorie $galerieCategorie): Response
    {
        $form = $this->createForm(GalerieCategorieType::class, $galerieCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('galerie_categorie_index');
        }

        return $this->render('galerie_categorie/edit.html.twig', [
            'galerie_categorie' => $galerieCategorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="galerie_categorie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GalerieCategorie $galerieCategorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$galerieCategorie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($galerieCategorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('galerie_categorie_index');
    }
}
