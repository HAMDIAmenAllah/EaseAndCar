<?php

namespace App\Controller;

use App\Entity\DetailsDevis;
use App\Entity\Devis;
use App\Form\DetailsDevisType;
use App\Repository\DetailsDevisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/detailsdevis")
 */
class DetailsDevisController extends AbstractController
{
    /**
     * @Route("/", name="detailsdevis_index", methods={"GET"})
     */
    public function index(DetailsDevisRepository $detailsDevisRepository): Response
    {
        return $this->render('details_devis/index.html.twig', [
            'details_devis' => $detailsDevisRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="detailsdevis_new")
     */
    public function new(Request $request, Devis $devis): Response
    {
        $detailsDevi = new DetailsDevis();
        $form = $this->createForm(DetailsDevisType::class, $detailsDevi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $detailsDevi->setDevis($devis);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailsDevi);
            $entityManager->flush();
            
            return $this->redirectToRoute('devis_car', ['id' => $devis->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('details_devis/new.html.twig', [
            'details_devi' => $detailsDevi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="detailsdevis_show", methods={"GET"})
     */
    public function show(DetailsDevis $detailsDevi): Response
    {
        return $this->render('details_devis/show.html.twig', [
            'details_devi' => $detailsDevi,
        ]);
    }

    /**
     * @Route("/{id}/edit/{devis}", name="detailsdevis_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailsDevis $detailsDevi, Devis $devis): Response
    {
        $form = $this->createForm(DetailsDevisType::class, $detailsDevi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('devis_car', ['id' => $devis->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('details_devis/edit.html.twig', [
            'details_devi' => $detailsDevi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/{devis}", name="detailsdevis_delete")
     */
    public function delete(Request $request, DetailsDevis $detailsDevi, Devis $devis): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailsDevi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailsDevi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('devis_car', ['id' => $devis->getId(),], Response::HTTP_SEE_OTHER);
    }
}
