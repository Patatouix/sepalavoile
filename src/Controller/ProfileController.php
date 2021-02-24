<?php

namespace App\Controller;

use DateTime;
use App\Entity\Media;
use App\Entity\Reservation;
use App\Form\ProfileType;
use App\Form\MediaFrontType;
use App\Repository\MediaRepository;
use App\Form\ChangePasswordFormType;
use App\Form\ReservationProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/infos", name="profile_infos")
     */
    public function profil(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new DateTime('NOW'));
            $this->getDoctrine()->getManager()->flush();
        }

        $imgProfil = null;
        foreach ($user->getMedias() as $media) {
            if ($media->getIsDisplayed()) {
                $imgProfil = $media;
            }
        }

        //formulaire de changement de mot de passe
        $formPwd = $this->createForm(ChangePasswordFormType::class);

        return $this->render('profile/infos.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
            'formPwd' => $formPwd->createView(),
            'imgProfil' => $imgProfil
        ]);
    }

    /**
     * @Route("/password", name="profile_password", methods={"POST"})
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $data = $request->request->get('change_password_form');
        $oldPassword = $data['oldPassword'];
        $newPasswords = $data['newPassword'];

        $user = $this->getUser();

        if ($newPasswords['first'] === $newPasswords['second']) {

            if ($encoder->isPasswordValid($user, $oldPassword)) {

                $user->setPassword(
                    $encoder->encodePassword($user, $newPasswords['first'])
                )
                ->setUpdatedAt(
                    new DateTime('NOW')
                );
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été modifié !');

            } else {
                $this->addFlash('success', 'Veuillez renseigner correctement votre mot de passe actuel.');
            }
        } else {
            $this->addFlash('success', 'Veuillez répéter correctement le nouveau mot de passe.');
        }

        return $this->redirectToRoute('profile_infos');
    }

    /**
     * @Route("/medias", name="profile_medias", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function medias(Request $request)
    {
        $user = $this->getUser();
        $medias = $user->getMedias();

        $medium = new Media();
        $form = $this->createForm(MediaFrontType::class, $medium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $medium->setCreatedAt( new DateTime('NOW'));
            $medium->setIsDisplayed(false);
            $user->addMedia($medium);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medium);
            $entityManager->flush();
        }

        return $this->render('profile/medias.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'medias' => $medias
        ]);
    }

    /**
     * @return Response
     * @Route("/toggleMedia", name="profile_toggleMedia", methods={"POST"})
     */
    public function toggleMedia(Request $request, MediaRepository $mediaRepository): Response
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

    /**
     * @Route("/achats", name="profile_achats")
     */
    public function achats(): Response
    {
        $user = $this->getUser();

        return $this->render('profile/achats.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/reservations", name="profile_reservations")
     */
    public function reservations(): Response
    {
        $user = $this->getUser();

        return $this->render('profile/reservations.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/reservations/{id}/edit", name="profile_reservations_edit", methods={"GET","POST"})
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function editReservation(Request $request, Reservation $reservation)
    {
        $form = $this->createForm(ReservationProfileType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_reservations');
        }

        return $this->render('profile/editReservation.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/messagerie", name="profile_messagerie")
     */
    public function messagerie(): Response
    {
        $user = $this->getUser();

        return $this->render('profile/messagerie.html.twig', [
            'user' => $user,
        ]);
    }
}
