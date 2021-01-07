<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Creneau;
use App\Entity\Produit;
use App\Entity\ProduitType;
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

        foreach ($panier as $typeProduit => $produits) {
            foreach ($produits as $idProduit => $achatsProduit) {

                $produit = $this->getDoctrine()->getRepository(Produit::class)->find($idProduit);

                if ($typeProduit == ProduitType::PRODUIT_TYPE_EVENT_NAME) {

                    foreach ($achatsProduit as $creneauId => $reservation) {

                        $creneau = $this->getDoctrine()->getRepository(Creneau::class)->find($creneauId);

                        //todo : check si les places dispos sont toujours là
                        $achat = new Achat();
                        $achat->setUser($this->getUser());
                        $achat->setProduit($produit);
                        $achat->setQuantite($reservation['quantite']);
                        $achat->setMontant($reservation['montant']);
                        $achat->setCreatedAt(new DateTime('NOW'));
                        $achat->setCreneau($creneau);
                        $entityManager->persist($achat);
                        $entityManager->flush();
                    }
                }
            }
        }

        $panier = [];
        $session->set('panier', $panier);
        $this->addFlash('success','Vos achats ont bien été enregistrés! Merci pour votre confiance !');

        return $this->redirectToRoute('home_page');
    }
}
