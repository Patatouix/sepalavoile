<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\ProfileType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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


            /*if ($encoder->isPasswordValid($user, $oldPassword)) {
                $encodedPassword = $encoder->encodePassword($user, $newPassword);
                dd($user);
                $this->addFlash('success', 'Votre mot de passe a bien été modifié !');
            } else {
                $this->addFlash('success', 'Mauvais mot de passe');
            }*/
            $user
                // ->setPassword(
                //     $passwordEncoder->encodePassword(
                //         $user,
                //         $form->get('password')->getData()
                //     )
                // )
                ->setUpdatedAt(
                    new DateTime('NOW')
                );

            $this->getDoctrine()->getManager()->flush();
        }

        //formulaire de changement de mot de passe
        $formPwd = $this->createForm(ChangePasswordFormType::class);

        return $this->render('profile/infos.html.twig', [
            'user' => $this->getUser(),
            'form' => $form->createView(),
            'formPwd' => $formPwd->createView()
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
     * @Route("/achats", name="profile_achats")
     */
    public function achats(): Response
    {
        return $this->render('');
    }
}
