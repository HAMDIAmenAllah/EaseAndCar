<?php

namespace App\Controller;

use App\Entity\Confidentialite;
use App\Form\ConfidentialiteType;
use App\Repository\ConfidentialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/confidentialite")
 */
class ConfidentialiteController extends AbstractController
{
    /**
     * @Route("/", name="confidentialite_index", methods={"GET"})
     */
    public function index(ConfidentialiteRepository $confidentialiteRepository): Response
    {
        return $this->render('confidentialite/index.html.twig', [
            'confidentialites' => $confidentialiteRepository->findAll(),
            'controller_name' => 'Politique de Confidentialite - Ease & Car',
            'var' => 'Confidentialite',
        ]);
    }
    /**
     * @Route("/liste", name="confidentialite_liste", methods={"GET"})
     */
    public function liste(ConfidentialiteRepository $confidentialiteRepository): Response
    {
        return $this->render('confidentialite/liste.html.twig', [
            'confidentialites' => $confidentialiteRepository->findAll(),
            'controller_name' => 'Politique de Confidentialite - Ease & Car',
            'var' => 'Confidentialite',
        ]);
    }

    /**
     * @Route("/new", name="confidentialite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $confidentialite = new Confidentialite();
        $form = $this->createForm(ConfidentialiteType::class, $confidentialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($confidentialite);
            $entityManager->flush();

            return $this->redirectToRoute('confidentialite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('confidentialite/new.html.twig', [
            'confidentialite' => $confidentialite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="confidentialite_show", methods={"GET"})
     */
    public function show(Confidentialite $confidentialite): Response
    {
        return $this->render('confidentialite/show.html.twig', [
            'confidentialite' => $confidentialite,
        ]);
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="1"}, name="confidentialite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Confidentialite $confidentialite): Response
    {
        $form = $this->createForm(ConfidentialiteType::class, $confidentialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('confidentialite_edit', ["id" => 1,], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('confidentialite/edit.html.twig', [
            'confidentialite' => $confidentialite,
            'form' => $form,
            'controller_name' => 'Politique de Confidentialite - Ease & Car',
            'var' => 'confidentialite',
        ]);
    }

    /**
     * @Route("/{id}", name="confidentialite_delete", methods={"POST"})
     */
    public function delete(Request $request, Confidentialite $confidentialite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$confidentialite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($confidentialite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('confidentialite_index', [], Response::HTTP_SEE_OTHER);
    }
}
