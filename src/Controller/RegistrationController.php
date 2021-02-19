<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user
                ->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
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

            // generate a signed url and email it to the user

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('sepalavoile@gmail.com', 'Sepalavoile Mail Bot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            return $this->redirectToRoute('home_page');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        //on veut vérifier l'utilisateur hors connexion
        //$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $id = $request->get('id');

        // Verify the user id exists and is not null
        if (null === $id) {
            return $this->redirectToRoute('home_page');
        }

        $user = $userRepository->find($id);

        // Ensure the user exists in persistence
        if (null === $user) {
            return $this->redirectToRoute('home_page');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('home_page');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre adresse email a été vérifiée. Vous pouvez maintenant vous connecter !');

        return $this->redirectToRoute('app_login');
    }
}
