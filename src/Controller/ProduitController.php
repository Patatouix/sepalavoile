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
    public function new(Request $request): Response
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
    }

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit, ProduitType $produitType): Response
    {
        $produitTypeSlug = $produit->getProduitType()->getSlug();

        //sélection du bon template suivant le type de produit
        switch ($produitTypeSlug) {
            case EntityProduitType::PRODUIT_TYPE_EVENT_SLUG:
                $templateFolder = EntityProduitType::PRODUIT_TYPE_EVENT_SLUG;
                break;
            case EntityProduitType::PRODUIT_TYPE_DONATION_SLUG:
                $templateFolder = EntityProduitType::PRODUIT_TYPE_DONATION_SLUG;
                break;
            case EntityProduitType::PRODUIT_TYPE_ADHESION_SLUG:
                $templateFolder = EntityProduitType::PRODUIT_TYPE_ADHESION_SLUG;
                break;
            default:
                $templateFolder = 'default';
                break;
        }

        return $this->render('produit/' . $templateFolder . '/show.html.twig', [
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

        //todo : check que quantite est <= à disponibilite
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $creneauId = $data['creneau_id'];
            $creneau = $this->getDoctrine()
                ->getRepository(Creneau::class)
                ->find($creneauId);

            $session = $request->getSession();
            $panier = $session->get('panier', []);
            //$panier = [];
            $panier[EntityProduitType::PRODUIT_TYPE_EVENT_NAME][$produit->getId()][$data['creneau_id']] = [
                'quantite' => $data['quantite'],
                'montant' => $produit->getPrix(),
                'produit_nom' => $produit->getNom(),
                'creneau_debut' => $creneau->getDebut(),
                'creneau_fin' => $creneau->getFin()
            ];
            //dd($panier[EntityProduitType::PRODUIT_TYPE_EVENT_NAME][$produit->getId()]);
            //dd($panier);
            $session->set('panier', $panier);

            $this->addFlash(
                'success',
                'Votre réservation a été ajoutée au panier !'
            );
        }

        return $this->render('produit/evenement/reservation.html.twig', [
            'produit' => $produit,
            'form' => $form->createView()
        ]);
    }
}
