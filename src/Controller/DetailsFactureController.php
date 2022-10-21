<?php

namespace App\Controller;

use App\Entity\DetailsFacture;
use App\Entity\Facture;
use App\Form\DetailsFactureType;
use App\Repository\DetailsFactureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/details/facture")
 */
class DetailsFactureController extends AbstractController
{
    /**
     * @Route("/", name="details_facture_index", methods={"GET"})
     */
    public function index(DetailsFactureRepository $detailsFactureRepository): Response
    {
        return $this->render('details_facture/index.html.twig', [
            'details_factures' => $detailsFactureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="details_facture_new")
     */
    public function new(Request $request, Facture $facture): Response
    {
        $detailsFacture = new DetailsFacture();
        $form = $this->createForm(DetailsFactureType::class, $detailsFacture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $detailsFacture->setFacture($facture); /* créer la relation */
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailsFacture);
            $entityManager->flush();

            return $this->redirectToRoute('afficher_facture',['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('details_facture/new.html.twig', [
            'details_facture' => $detailsFacture,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="details_facture_show", methods={"GET"})
     */
    public function show(DetailsFacture $detailsFacture): Response
    {
        return $this->render('details_facture/show.html.twig', [
            'details_facture' => $detailsFacture,
        
        ]);
    }
    /**
     * @Route("/{id}/edit", name="details_facture_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailsFacture $detailsFacture): Response
    {
        $form = $this->createForm(DetailsFactureType::class, $detailsFacture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('details_facture_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('details_facture/edit.html.twig', [
            'details_facture' => $detailsFacture,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}/modif-ligne/{facture}", name="modif_ligne")
     */
    public function modifierLigne(Request $request, Facture $facture, DetailsFacture $detailsFacture): Response
    {
        $form = $this->createForm(DetailsFactureType::class, $detailsFacture);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();
            return $this->redirectToRoute('modif_ligne', ['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('details_facture/edit.html.twig', [
            'detailsFacture' => $detailsFacture,
            'facture' => $facture,
            'var' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{facture}", name="details_facture_delete")
     */
    public function delete(Request $request, DetailsFacture $detailsFacture, Facture $facture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailsFacture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailsFacture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('afficher_facture', ['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
    }
}
