<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\MediaCategory;
use App\Form\MediaType;
use App\Repository\MediaCategoryRepository;
use App\Repository\MediaRepository;
use DateTime;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/media")
 */
class MediaController extends AbstractController
{
    /**
     * @Route("/", name="media_index", methods={"GET"})
     */
    public function index(MediaRepository $mediaRepository): Response
    {
        return $this->render('media/index.html.twig', [
            'media' => $mediaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/header", name="media_index_header", methods={"GET"})
     */
    public function indexHeader(MediaCategoryRepository $mediaCategoryRepository): Response
    {

        $mediaCategoryHeader = $mediaCategoryRepository->findBy(['name' => [
            MediaCategory::MEDIA_CATEGORY_HEADERVIDEO_NAME,
            MediaCategory::MEDIA_CATEGORY_SLIDERPHOTO_NAME
        ]]);

        $mediaCategoryHeader = $this->getDoctrine()->getRepository(Media::class)->findBy(['mediaCategory' => $mediaCategoryHeader], ['createdAt' => 'desc']);

        return $this->render('media/index.html.twig', [
            'media' => $mediaCategoryHeader,
        ]);
    }
    
    /**
     * @Route("/video", name="media_index_video", methods={"GET"})
     */
    public function indexVideo(MediaCategoryRepository $mediaCategoryRepository): Response
    {

        $mediaCategoryVideo = $mediaCategoryRepository->findBy(['name' => [
            MediaCategory::MEDIA_CATEGORY_VIDEO_NAME,
        ]]);

        $mediaCategoryVideo = $this->getDoctrine()->getRepository(Media::class)->findBy(['mediaCategory' => $mediaCategoryVideo], ['createdAt' => 'desc']);

        return $this->render('media/index.html.twig', [
            'media' => $mediaCategoryVideo,
        ]);
    }

    /**
     * @Route("/new", name="media_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $medium->setCreatedAt( new DateTime('NOW'));
            $medium->setIsDisplayed(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medium);
            $entityManager->flush();

            return $this->redirectToRoute('media_index');
        }

        return $this->render('media/new.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/modal", name="media_new_modal", methods={"GET","POST"})
     */
    public function newInEntitiesModal(Request $request): Response
    {
        $medium = new Media();
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $medium->setCreatedAt(new DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medium);
            $entityManager->flush();

            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        return $this->render('media/_form_modal.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="media_show", methods={"GET"})
     */
    public function show(Media $medium): Response
    {
        return $this->render('media/show.html.twig', [
            'medium' => $medium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="media_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Media $medium): Response
    {
        $form = $this->createForm(MediaType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $medium->setUpdatedAt( new DateTime('NOW'));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('media_index');
        }

        return $this->render('media/edit.html.twig', [
            'medium' => $medium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="media_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Media $medium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($medium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('media_index');
    }

    /**
     * @return Response
     * @Route("/{id}/toggleDisplayed", name="media_toggleDisplayed", methods={"POST"})
     */
    public function toggleDisplayed(Request $request, MediaRepository $mediaRepository): Response
    {
        $mediaId = $request->request->get('id');
        $isDisplayed = $request->request->get('isDisplayed');

        $media = $mediaRepository->find($mediaId);
        $media->setIsDisplayed($isDisplayed? '0' : '1');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($media);
        $entityManager->flush();

        $referer = $request->headers->get('referer');
            return $this->redirect($referer);
    }
}
