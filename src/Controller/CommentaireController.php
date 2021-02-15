<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireAdminType;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="admin_commentaire_index", methods={"GET"})
     */
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/admin/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_commentaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commentaire $commentaire): Response
    {
        $form = $this->createForm(CommentaireAdminType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_commentaire_index');
        }

        return $this->render('commentaire/admin/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_commentaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commentaire $commentaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_commentaire_index');
    }

    /**
     * @return Response
     * @Route("/{id}/togglePublished", name="admin_commentaire_togglePublished", methods={"POST"})
     */
    public function togglePublished(Request $request, CommentaireRepository $commentaireRepository): Response
    {
        $commentaireId = $request->request->get('id');
        $isPublished = $request->request->get('isPublished');

        $commentaire = $commentaireRepository->find($commentaireId);
        $commentaire->setIsPublished($isPublished ? '0' : '1');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commentaire);
        $entityManager->flush();

        return $this->redirectToRoute('admin_commentaire_index');
    }
}
