<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user/", name="admin_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/user/new", name="admin_user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user
                ->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                )
                ->setCreatedAt(
                    new DateTime('NOW')
                )
                ->setRoles(
                    ["ROLE_USER"]

                );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="admin_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show_admin.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/admin/user/{id}/edit", name="admin_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->remove('password');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="admin_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * @Route("/user/profile/")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     */
    public function profile(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->remove('password');

        $form->handleRequest($request);
        //$form = $this->createForm(ChangePasswordFormType::class);
        //$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /*$oldPassword = $form->getData('oldPassword');
            $newPassword = $form->getData('newPassword');

            if ($encoder->isPasswordValid($user, $oldPassword)) {
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

        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
