<?php

namespace App\Controller;

use App\Entity\CLient;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Repository\ProduitRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;

class StripeController extends AbstractController
{
    /**
     * @Route("/createpaiement", name="stripe")
     */
    public function index(Session $session, EntityManagerInterface $entityManagerInterface, ProduitRepository $produitRepository): Response
    {
        Stripe::setApiKey($this->getParameter('stripe_key'));

        $commande = new Commande();
        $commande->setEtat(false);
        $commande->setCreatedAt(new DateTimeImmutable());

        $client = $entityManagerInterface->find(CLient::class, 1);
        $commande->setCLient($client);

        $entityManagerInterface->persist($commande);
        $entityManagerInterface->flush();

        $details = $session->get('panier', []);
        foreach ($details as $detail) {
            $detail->setDetailCommande($commande);
            $detail->setDetailProduit($produitRepository->find($detail->getDetailProduit()->getId()));
            $entityManagerInterface->persist($detail);
            $entityManagerInterface->flush();

            //on parametre les données à envoyer à stripe
            $detail_commande[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $detail->getDetailProduit()->getNom(),
                    ],
                    'unit_amount' => $detail->getDetailProduit()->getPrix() * 100,
                ],
                'quantity' => $detail->getQte(),
            ];
        }

        $stripesession = \Stripe\Checkout\Session::create([
            'line_items' => [$detail_commande],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('stripe_success', [
                'id' => $commande->getId()
            ], 0),
            'cancel_url' => $this->generateUrl('stripe_error', [
                'id' => $commande->getId()
            ], 0),
        ]);
        return $this->redirect($stripesession->url);
    }


    /**
     * @Route("/stripe-error/{id}", name="stripe_error")
     */
    public function error(Commande $commande)
    {
        return $this->render('stripe/error.html.twig');
    }

    /**
     * @Route("/stripe-success/{id}", name="stripe_success")
     */
    public function success(Commande $commande, EntityManagerInterface $entityManagerInterface, Session $session)
    {

        $session->remove("panier");
        $cookie = Cookie::create('panierarticle', count($session->get("panier", [])), time() + 36000);

        $response = $this->redirectToRoute('listecommande', [
            'id' => $commande->getId(),
        ]);

        $response->headers->setCookie($cookie);

        return $response->send();
    }


    /**
     * @Route("/facture/{id}", name="listecommande")
     */

    public function showSuccess(Commande $commande, EntityManagerInterface $entityManagerInterface, Session $session)
    {
        $commande->setEtat(true);
        $entityManagerInterface->flush();

        $details = $commande->getDetails();
        $client = $commande->getCLient();

        return $this->render('stripe/success.html.twig', [
            'commande' => $commande,
            'details' => $details,
            'client' => $client
        ]);
    }
}
