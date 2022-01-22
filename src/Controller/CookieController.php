<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CookieController extends AbstractController
{
    /**
     * @Route("/load", name="loadcookie")
     */
    public function cookie(Session $session)
    {
        $response = $this->redirectToRoute('listpanier');

        $nombrearticle = count($session->get('panier', []));
        $cookie = Cookie::create('panierarticle', $nombrearticle, time() + 36000);
        $response->headers->setCookie($cookie);

        return $response->send();
    }


    /**
     * @Route("/editcookie", name="editcookie")
     */
    public function editCookie(Session $session)
    {
        $response = $this->redirectToRoute('listpanier');

        $nombrearticle = count($session->get('panier', []));
        $cookie = Cookie::create('panierarticle', $nombrearticle, time() + 36000);
        $response->headers->setCookie($cookie);
        return $response->send();
    }

    /**
     * @Route("/removecookie", name="removecookie")
     */
    public function removeCookie(Session $session)
    {
        $response = $this->redirectToRoute('home');
        $response->headers->remove('panierarticle');
        return $response->send();
    }
}
