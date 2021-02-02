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
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit/", name="produit_index", methods={"GET"})
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
     * Admin version of produit index
     * @Route("/admin/produit/", name="admin_produit_index", methods={"GET"})
     */
    public function adminIndex(ProduitRepository $produitRepository, Request $request)
    {
        //$data = new ProduitSearchData();
        //$form = $this->createForm(ProduitSearchType::class, $data);
        //$form->handleRequest($request);
        //$produits = $produitRepository->findSearch($data);
        $produits = $produitRepository->findAll();
        return $this->render('produit/admin/index.html.twig', [
            'produits' => $produits,
            //'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/produit/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setCreatedAt(new DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('admin_produit_index');
        }

        return $this->render('produit/admin/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/produit/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        $produitTypeSlug = $produit->getProduitType()->getSlug();

        return $this->render('produit/' . $produitTypeSlug . '/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * Admin version of produit show
     * @Route("/admin/produit/{id}", name="admin_produit_show", methods={"GET"})
     */
    public function adminShow(Produit $produit): Response
    {
        $produitTypeSlug = $produit->getProduitType()->getSlug();

        return $this->render('produit/' . $produitTypeSlug . '/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/admin/produit/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_produit_index');
        }

        return $this->render('produit/admin/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/produit/{id}", name="admin_produit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_produit_index');
    }

     /**
     * @Route("/produit/{id}/reservation", name="produit_reservation", methods={"GET","POST"})
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
            if ($creneau->placesDisponibles() >= $data['quantitePlaces']) {
                //on met dans le panier (session)
                $session = $request->getSession();
                $panier = $session->get('panier', []);
                $panier['reservations'][$produit->getId()][$data['creneau_id']] = [
                    'quantite' => $data['quantitePlaces'],
                    'prixPaye' => $produit->getPrix(),
                    'produit_nom' => $produit->getNom(),
                    'creneau_debut' => $creneau->getDebut(),
                    'creneau_fin' => $creneau->getFin()
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
     * @Route("/produit/{id}/donation", name="produit_donation", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function donation(Request $request, Produit $produit): Response
    {
        $form = $this->createFormBuilder()
            ->add('prixPaye', RangeType::class, [
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
            $panier['achats'][$produit->getId()] = [
                'prixPaye' => $data['prixPaye'],
                'produit_type' => EntityProduitType::PRODUIT_TYPE_DONATION_NAME,
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
     * @Route("/produit/{id}/adhesion", name="produit_adhesion", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function adhesion(Request $request, Produit $produit): Response
    {
        $form = $this->createFormBuilder()
            ->add('prixPaye', RangeType::class, [
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
            $panier['achats'][$produit->getId()] = [
                'prixPaye' => $data['prixPaye'],
                'produit_type' => EntityProduitType::PRODUIT_TYPE_ADHESION_NAME,
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
