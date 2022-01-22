<?php

namespace App\Controller;

use App\Entity\CLient;
use App\Entity\User;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="client")
     */
    public function index(Client $client, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($client);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('show_profile', [
                'id' => $client->getId()
            ]);
        }

        return $this->renderForm('client/index.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/profile/show/{id}", name="show_profile")
     */
    public function showProfile(CLient $client)
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }
}
