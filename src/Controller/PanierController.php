<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Creneau;
use App\Entity\Produit;
use App\Entity\ProduitType;
use App\Entity\Reservation;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier_index")
     */
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'panier' => $panier
        ]);
    }

    /**
     * @Route("/panier/validate", name="panier_validate")
     */
    public function validate(Request $request)
    {
        $session = $request->getSession();
        $panier = $session->get('panier', []);

        //panier vide
        if(!$panier) {
            $this->addFlash('success','Panier vide !');
            return $this->redirectToRoute('panier_index');
        }

        $entityManager = $this->getDoctrine()->getManager();

        if(isset($panier['reservations'])) {
            foreach ($panier['reservations'] as $idProduit => $reservationsProduit) {

                foreach ($reservationsProduit as $creneauId => $reservation) {

                    $creneau = $this->getDoctrine()->getRepository(Creneau::class)->find($creneauId);

                    //todo : check si les places dispos sont toujours là
                    $achat = new Reservation();
                    $achat->setUser($this->getUser());
                    $achat->setQuantitePlaces($reservation['quantite']);
                    $achat->setPrixPaye($reservation['prixPaye']);
                    $achat->setCreatedAt(new DateTime('NOW'));
                    $achat->setCreneau($creneau);
                    $entityManager->persist($achat);
                    $entityManager->flush();
                }
            }
        }
        if(isset($panier['achats'])) {
            foreach ($panier['achats'] as $idProduit => $achatProduit) {

                $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);

                $achat = new Achat();
                $achat->setUser($this->getUser());
                $achat->setProduit($produit);
                $achat->setPrixPaye($achatProduit['prixPaye']);
                $achat->setCreatedAt(new DateTime('NOW'));
                $entityManager->persist($achat);
                $entityManager->flush();
            }
        }

        $panier = [];
        $session->set('panier', $panier);
        $this->addFlash('success','Vos achats ont bien été enregistrés! Merci pour votre confiance !');

        return $this->redirectToRoute('home_page');
    }
}
