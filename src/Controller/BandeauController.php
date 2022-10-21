<?php

namespace App\Controller;

use App\Entity\Bandeau;
use App\Form\BandeauType;
use App\Repository\BandeauRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bandeau")
 */
class BandeauController extends AbstractController
{
    /**
     * @Route("/", name="bandeau_index", methods={"GET"})
     */
    public function index(BandeauRepository $bandeauRepository): Response
    {
        return $this->render('bandeau/index.html.twig', [
            'bandeaus' => $bandeauRepository->findAll(),
            'controller_name' => 'Bandeau Electronique - Ease & Car',
            'var' => 'Bandeau',
        ]);
    }

    /**
     * @Route("/new", name="bandeau_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bandeau = new Bandeau();
        $form = $this->createForm(BandeauType::class, $bandeau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bandeau);
            $entityManager->flush();

            return $this->redirectToRoute('bandeau_index', [
                'controller_name' => 'Bandeau Electronique - Ease & Car',
                'var' => 'Bandeau',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bandeau/new.html.twig', [
            'bandeau' => $bandeau,
            'form' => $form,
            'controller_name' => 'Bandeau Electronique - Ease & Car',
            'var' => 'Bandeau',
        ]);
    }

    /**
     * @Route("/{id}", name="bandeau_show", methods={"GET"})
     */
    public function show(Bandeau $bandeau): Response
    {
        return $this->render('bandeau/show.html.twig', [
            'bandeau' => $bandeau,
            'controller_name' => 'Bandeau Electronique - Ease & Car',
            'var' => 'Bandeau',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bandeau_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bandeau $bandeau): Response
    {
        $form = $this->createForm(BandeauType::class, $bandeau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bandeau_index', [
                'controller_name' => 'Bandeau Electronique - Ease & Car',
                'var' => 'Bandeau',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bandeau/edit.html.twig', [
            'bandeau' => $bandeau,
            'form' => $form,
            'controller_name' => 'Bandeau Electronique - Ease & Car',
            'var' => 'Bandeau',
        ]);
    }

    /**
     * @Route("/{id}", name="bandeau_delete", methods={"POST"})
     */
    public function delete(Request $request, Bandeau $bandeau): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bandeau->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bandeau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bandeau_index', [
            'controller_name' => 'Bandeau Electronique - Ease & Car',
            'var' => 'Bandeau',
        ], Response::HTTP_SEE_OTHER);
    }
}
