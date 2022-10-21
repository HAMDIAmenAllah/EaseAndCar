<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Devis;
use App\Entity\Notes;
use App\Form\ClientType;
use App\Form\NotesType;
use App\Repository\ClientRepository;
use App\Repository\NotesRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET","POST"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        $client = new client;
        $form = $this->createForm(ClientType::class, $client);
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
            'var'=>'client',
/*             'form' => $form->createView(),
 */        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/new.html.twig', [
            'client' => $client,
            'form' => $form,
            'var' => 'client',
            
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client, NotesRepository $notesRepository): Response
    {
        return $this->render('client/show.html.twig', [
            'notes' => $notesRepository->findBy(['relationClient'=>$client]),
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client, Notes $note): Response
    {
        $form = $this->createForm(ClientType::class, $client)
        ->add('statut', ChoiceType::class, [
            "choices" => [
                "nouveau" => "nouveau",
                "en attente" => "en attente",
                "gagner" => "gagné",
                "perdu" => "perdu",
                ],
                'expanded' => true,
            ]
            
            );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }
        
        $note = new Notes();
        $form1 = $this->createForm(NotesType::class, $note);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $comm = $form1->getData();
            $comm->setRelationClient($client);
            $comm->setCreatedAt(new DateTimeImmutable());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comm);
            $entityManager->flush();

            return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            'var' => 'client',
        ]);
    }

    /**
     * @Route("/{id}/modifier/{devis}", name="client_modifier", methods={"GET","POST"})
     */
    public function modifier(Request $request, Client $client, Devis $devis): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('devis_car', ['id' => $devis->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/modifier.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
            'var' => 'client',
        ]);
    }

    /**
     * @Route("/{id}", name="client_delete", methods={"POST"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index', [], Response::HTTP_SEE_OTHER);
        
    }
}
