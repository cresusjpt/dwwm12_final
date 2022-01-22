<?php

namespace App\Controller;

use App\Entity\Detail;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/panier/{id}", name="panier")
     */
    public function index(Produit $produit, Session $session): Response
    {
        //on crée le détail commande
        $detail = new Detail();
        $detail->setDetailProduit($produit);
        $detail->setQte(1);

        $panier = $session->get('panier', []);
        //on ajoute ce détail au panier s'il existe pas encore.
        foreach ($panier as $det) {
            if ($det->getDetailProduit()->getId() == $detail->getDetailProduit()->getId()) {
                return $this->redirectToRoute('home');
            }
        }
        $panier[] = $detail;
        $session->set('panier', $panier);

        return $this->redirectToRoute('loadcookie');
    }

    /**
     * @Route("/list-panier/", name="listpanier")
     */
    public function list(Session $session)
    {
        $detproduits = $session->get('panier', []);

        return $this->render('panier/list.html.twig', [
            'detproduits' => $detproduits,
        ]);
    }

    /**
     * @Route("/retirer-panier/{id}", name="retirerpanier")
     */
    public function remove(Produit $produit, Session $session)
    {
        $panier = $session->get('panier', []);

        foreach ($panier as $key => $det) {
            if ($det->getDetailProduit()->getId() == $produit->getId()) {
                unset($panier[$key]);
            }
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('editcookie');
    }
}
