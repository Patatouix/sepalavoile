<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Sondage;
use App\Entity\Reponse;
use App\Form\QuestionEmbeddedFormType;
use App\Form\SondageType;
use App\Form\QuestionType;
use App\Repository\SondageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Question\Question as QuestionQuestion;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SondageController extends AbstractController
{
    /**
     * @Route("/sondage/", name="sondage_index", methods={"GET"})
     */
    public function index(SondageRepository $sondageRepository): Response
    {
        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/sondage/", name="admin_sondage_index", methods={"GET"})
     */
    public function indexAdmin(SondageRepository $sondageRepository): Response
    {
        return $this->render('sondage/admin/index.html.twig', [
            'sondages' => $sondageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/sondage/new", name="admin_sondage_new", methods={"GET","POST"})
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

            return $this->redirectToRoute('admin_sondage_index');
        }

        return $this->render('sondage/admin/new.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/sondage/{id}", name="sondage_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Sondage $sondage): Response
    {
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
     * @Route("/admin/sondage/{id}", name="admin_sondage_show", methods={"GET", "POST"})
     */
    public function showAdmin(Request $request, Sondage $sondage): Response
    {
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

            return $this->redirectToRoute('admin_sondage_index');
        }

        return $this->render('sondage/admin/show.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/sondage/{id}/edit", name="admin_sondage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sondage $sondage): Response
    {
        $form = $this->createForm(SondageType::class, $sondage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_sondage_index');
        }

        return $this->render('sondage/admin/edit.html.twig', [
            'sondage' => $sondage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/sondage/{id}", name="admin_sondage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sondage $sondage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sondage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sondage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_sondage_index');
    }
    /**
     * @Route("admin/sondage/createquestion", name="admin_sondage_createquestion", methods={"GET","POST"})
     */
    public function createquestion(Request $request): Response
    {

        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('admin_sondage_index');
        }

        return $this->render('sondage/admin/createquestion.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

