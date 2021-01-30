<?php

namespace App\Controller;

use App\Entity\Creneau;
use App\Entity\Produit;
use App\Entity\ProduitType;
use DateTime;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout", methods={"POST"})
     */
    public function createCheckoutSession(Request $request): Response
    {
        Stripe::setApiKey('sk_test_51IEbyABN8DgmFBU0ogLizBniFptxBf0sbQctgaDlINDHdN3ZRMTViclCcSOmLTaCYwMRaOgo7ToMjY3fOl93L6hh00N3hpdgjo');

        $session = $request->getSession();
        $panier = $session->get('panier', []);

        $produitsData = array();

        //construire le tableau de produits à partir du panier de la session, dans un format attendu par Stripes
        foreach ($panier as $typeProduit => $produits) {
            foreach ($produits as $idProduit => $achatsProduit) {

                $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);

                if ($typeProduit == ProduitType::PRODUIT_TYPE_EVENT_NAME) {

                    foreach ($achatsProduit as $creneauId => $reservation) {

                        $creneau = $this->getDoctrine()->getRepository(Creneau::class)->find($creneauId);

                        $produitData = [
                            'price_data' => [
                                'currency' => 'eur',
                                'product_data' => [
                                    'name' => $produit->getNom() . ' - ' . ($creneau->getDebut())->format('d/m/Y'),
                                ],
                                'unit_amount' => ($reservation['montant'] * 100),
                            ],
                            'quantity' => $reservation['quantite'],
                        ];
                        $produitsData[] = $produitData;
                    }
                } elseif ($typeProduit == ProduitType::PRODUIT_TYPE_ADHESION_NAME || $typeProduit == ProduitType::PRODUIT_TYPE_DONATION_NAME) {

                    $produitData = [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => $produit->getNom(),
                            ],
                            'unit_amount' => ($achatsProduit['montant'] * 100),
                        ],
                        'quantity' => 1,
                    ];
                    $produitsData[] = $produitData;
                }
            }
        }

        //créer la session de paiement avec les produits du panier
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $produitsData,
            'mode' => 'payment',
            'success_url' => 'http://127.0.0.1:8000/panier/validate',
            'cancel_url' => 'http://127.0.0.1:8000/panier',
          ]);

        return new JsonResponse(['id' => $session->id]);
    }
}
