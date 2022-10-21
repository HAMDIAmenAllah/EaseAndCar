<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\Easeandcar;
use App\Form\EaseandcarType;
use App\Repository\EaseandcarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/easeandcar")
 */
class EaseandcarController extends AbstractController
{
    /**
     * @Route("/", name="easeandcar_index", methods={"GET"})
     */
    public function index(EaseandcarRepository $easeandcarRepository): Response
    {
        return $this->render('easeandcar/index.html.twig', [
            'easeandcars' => $easeandcarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="easeandcar_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $easeandcar = new Easeandcar();
        $form = $this->createForm(EaseandcarType::class, $easeandcar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($easeandcar);
            $entityManager->flush();

            return $this->redirectToRoute('easeandcar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('easeandcar/new.html.twig', [
            'easeandcar' => $easeandcar,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="easeandcar_show", methods={"GET"})
     */
    public function show(Easeandcar $easeandcar): Response
    {
        return $this->render('easeandcar/show.html.twig', [
            'easeandcar' => $easeandcar,
        ]);
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="1"}, name="easeandcar_edit")
     */
    public function edit(Request $request, Easeandcar $easeandcar): Response
    {
        $form = $this->createForm(EaseandcarType::class, $easeandcar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('easeandcar_edit', ["id" => 1,], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('easeandcar/edit.html.twig', [
            'easeandcar' => $easeandcar,
            'form' => $form,
            'var' => 'easeandcar',
        ]);
    }

    /**
     * @Route("/{id}/modifier/{devis}", requirements={"id"="1"}, name="easeandcar_modifier")
     */
    public function modifier(Request $request, Easeandcar $easeandcar, Devis $devis): Response
    {
        $form = $this->createForm(EaseandcarType::class, $easeandcar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('devis_car', ['id' => $devis->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('easeandcar/modifier.html.twig', [
            'easeandcar' => $easeandcar,
            'form' => $form,
            'var' => 'easeandcar',
        ]);
    }

    /**
     * @Route("/{id}", name="easeandcar_delete", methods={"POST"})
     */
    public function delete(Request $request, Easeandcar $easeandcar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$easeandcar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($easeandcar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('easeandcar_index', [], Response::HTTP_SEE_OTHER);
    }
}
