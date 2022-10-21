<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Repository\GalerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gestionimage")
 */
class GestionImageController extends AbstractController
{
    /**
     * @Route("/", name="galerie_index")
     */
    public function index(GalerieRepository $galerieRepository): Response
    {
        return $this->render('galerie/test.html.twig', [ 
            /* 'galeries' => $galerieRepository->findBy(['contrat'=>$id]), */
            'var' => 'Galerie',
        ]);
        
    }

    /**
     * @Route("/new/{nom}/{etat}/{id}", name="galerie_new")
     */
    public function new(Request $request, String $nom, string $etat, string $id)
    {
        $galerie = new Galerie();
        $galerie->setNom($nom);
        $galerie->setContrat($id);
        if ($etat == "depart") {
            $galerie->setAller(1);
            $galerie->setRetour(0);
        }
        else if ($etat == "retour") {
            $galerie->setAller(0);
            $galerie->setRetour(1);
        }
        else{
            exit;
        }
        /* $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            return $this->redirectToRoute('galerie_index', [], Response::HTTP_SEE_OTHER);
        }*/
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($galerie);
        $entityManager->flush();
        return  new JsonResponse(['data'=>'Image '.$galerie->getNom().' bien enregistrée']);
        /* $this->renderForm('galerie/new.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
        ]);  */
    }

    /**
     * @Route("/{id}", name="galerie_show")
     */
    public function show(/* Galerie $galerie,  */GalerieRepository $galerieRepository, string $id): Response
    {
        return $this->render('galerie/index.html.twig', [
            /* 'galerie' => $galerie, */
            'galeries' => $galerieRepository->findBy(['contrat'=>$id]),

        ]);
    }

    /**
     * @Route("/{id}/edit", name="galerie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Galerie $galerie): Response
    {
        $form = $this->createForm(GalerieType::class, $galerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('galerie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('galerie/edit.html.twig', [
            'galerie' => $galerie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="galerie_delete", methods={"POST"})
     */
    public function delete(Request $request, Galerie $galerie): Response
    {
        dd($request);
        if ($this->isCsrfTokenValid('delete'.$galerie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($galerie);
            $entityManager->flush();
        }
        return new JsonResponse(['data'=>'Image '.$galerie->getNom().' bien supprimée']);
        /* return $this->redirectToRoute('galerie_index', [], Response::HTTP_SEE_OTHER); */
    }
}
