<?php

namespace App\Controller;

use App\Data\ProduitSearchData;
use App\Entity\Creneau;
use App\Entity\Produit;
use App\Entity\ProduitType as EntityProduitType;
use App\Form\ProduitSearchType;
use App\Form\ProduitType;
use App\Form\ReservationType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository, Request $request)
    {
        $data = new ProduitSearchData();
        $form = $this->createForm(ProduitSearchType::class, $data);
        $form->handleRequest($request);
        $produits = $produitRepository->findSearch($data);
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="produit_new", methods={"GET","POST"})
     */
    /*public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }*/

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit, ProduitType $produitType): Response
    {
        $produitTypeSlug = $produit->getProduitType()->getSlug();

        return $this->render('produit/' . $produitTypeSlug . '/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

     /**
     * @Route("/{id}/reservation", name="produit_reservation", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function reservation(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ReservationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $creneau = $this->getDoctrine()
                ->getRepository(Creneau::class)
                ->find($data['creneau_id']);

            //si assez de places disponibles
            if ($creneau->placesDisponibles() >= $data['quantite']) {
                //on met dans le panier (session)
                $session = $request->getSession();
                $panier = $session->get('panier', []);
                $panier[EntityProduitType::PRODUIT_TYPE_EVENT_NAME][$produit->getId()][$data['creneau_id']] = [
                    'quantite' => $data['quantite'],
                    'montant' => $produit->getPrix(),
                    'produit_nom' => $produit->getNom(),
                    'creneau_debut' => $creneau->getDebut(),
                    'creneau_fin' => $creneau->getFin(),
                    'prix' => $produit->getPrix()
                ];
                $session->set('panier', $panier);

                $this->addFlash('success', 'Votre réservation a été ajoutée au panier !');

            //sinon on ne fait rien et on met msg d'erreur
            } else {
                $this->addFlash('success','Pas assez de places disponibles ! Recommencez votre réservation, sans tricher cette fois !');
            }
        }

        return $this->render('produit/evenement/reservation.html.twig', [
            'produit' => $produit,
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/{id}/donation", name="produit_donation", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function donation(Request $request, Produit $produit): Response
    {
        $form = $this->createFormBuilder()
            ->add('montant', RangeType::class, [
                'label' => 'Je souhaite donner : ',
                'attr' => [
                    'min' => $produit->getPrix(),
                    'max' => 100,
                    'step' => 1,
                    'value' => $produit->getPrix()
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            //on met dans le panier (session)
            $session = $request->getSession();
            $panier = $session->get('panier', []);
            $panier[EntityProduitType::PRODUIT_TYPE_DONATION_NAME][$produit->getId()] = [
                'quantite' => 1,
                'montant' => $data['montant'],
                'produit_nom' => $produit->getNom(),
            ];
            $session->set('panier', $panier);
            $this->addFlash('success', 'Votre donation a été ajoutée au panier !');
            return $this->redirectToRoute('produit_show', ['id' => $produit->getId()]);
        }

        return $this->render('produit/donation/donation.html.twig', [
            'produit' => $produit,
            'form' => $form->createView()
        ]);
    }

     /**
     * @Route("/{id}/adhesion", name="produit_adhesion", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function adhesion(Request $request, Produit $produit): Response
    {
        $form = $this->createFormBuilder()
            ->add('montant', RangeType::class, [
                'label' => 'Montant de mon adhésion : ',
                'attr' => [
                    'min' => $produit->getPrix(),
                    'max' => 100,
                    'step' => 1,
                    'value' => $produit->getPrix()
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            //on met dans le panier (session)
            $session = $request->getSession();
            $panier = $session->get('panier', []);
            $panier[EntityProduitType::PRODUIT_TYPE_ADHESION_NAME][$produit->getId()] = [
                'quantite' => 1,
                'montant' => $data['montant'],
                'produit_nom' => $produit->getNom(),
            ];
            $session->set('panier', $panier);
            $this->addFlash('success', 'Votre adhésion a été ajoutée au panier !');
            return $this->redirectToRoute('produit_show', ['id' => $produit->getId()]);
        }

        return $this->render('produit/adhesion/adhesion.html.twig', [
            'produit' => $produit,
            'form' => $form->createView()
        ]);
    }
}
