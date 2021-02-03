<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Sondage;
use App\Entity\Reponse;
use App\Form\QuestionEmbeddedFormType;
use App\Form\SondageType;
use App\Repository\SondageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sondage")
 */
class SondageController extends AbstractController
{
    /**
     * @Route("/", name="sondage_index", methods={"GET"})
     */
    public function index(SondageRepository $sondageRepository): Response
    {
        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sondage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sondage = new Sondage();
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sondage);
            $entityManager->flush();

            return $this->redirectToRoute('sondage_index');
        }

        return $this->render('sondage/new.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sondage_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Sondage $sondage): Response
    {

        /*if ($this->getUser() === null || !$this->isGranted('ROLE_USER')) {
            $this->addFlash('warning', 'Vous devez être connecté pour participer au sondage');
            return $this->redirectToRoute('app_login');
        }*/

        $questions = $sondage->getQuestions();
        $form = $this->createFormBuilder();

        foreach ($questions as $question) {
            $form->add('question_' . $question->getId(), TextType::class,[
                'label' => $question->getLabel(),
                'property_path' => '[' . $question->getId() . '][reponse]'
            ]);
        }
        $form = $form->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $repo = $this->getDoctrine()->getRepository(Question::class);

            foreach ($form->getData() as $idQuestion => $dataReponse) {

                $reponse = new Reponse();
                $question = $repo->find($idQuestion);
                $reponse->setContenu($dataReponse['reponse'])
                        ->setQuestion($question)
                        ->setUser($this->getUser());
                $entityManager->persist($reponse);
            }

            $entityManager->flush();

            $this->addFlash('success','Vos réponses ont bien été enregistrées ! Merci !');

            return $this->redirectToRoute('sondage_index');
        }

        return $this->render('sondage/show.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sondage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sondage $sondage): Response
    {
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sondage_index');
        }

        return $this->render('sondage/edit.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sondage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sondage $sondage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sondage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sondage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sondage_index');
    }
}
