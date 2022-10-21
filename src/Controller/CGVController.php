<?php

namespace App\Controller;

use App\Entity\CGV;
use App\Form\CGVType;
use App\Repository\CGVRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cgv")
 */
class CGVController extends AbstractController
{
    /**
     * @Route("/", name="cgv_index", methods={"GET"})
     */
    public function index(CGVRepository $cGVRepository): Response
    {
        return $this->render('cgv/index.html.twig', [
            'cgvs' => $cGVRepository->findAll(),
            'controller_name' => 'CGV - Ease & Car',
            'var' => 'CGV',
        ]);
    }
    /**
     * @Route("/liste", name="cgv_liste", methods={"GET"})
     */
    public function liste(CGVRepository $cGVRepository): Response
    {
        return $this->render('cgv/index.html.twig', [
            'cgvs' => $cGVRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cgv_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cGV = new CGV();
        $form = $this->createForm(CGVType::class, $cGV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cGV);
            $entityManager->flush();

            return $this->redirectToRoute('cgv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cgv/new.html.twig', [
            'cgv' => $cGV,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cgv_show", methods={"GET"})
     */
    public function show(CGV $cGV): Response
    {
        return $this->render('cgv/show.html.twig', [
            'cgv' => $cGV,
        ]);
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="1"}, name="cgv_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CGV $cGV): Response
    {
        $form = $this->createForm(CGVType::class, $cGV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cgv_edit', ["id" => 1,], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cgv/edit.html.twig', [
            'cgv' => $cGV,
            'form' => $form,
            'var' => 'CGV',
        ]);
    }

    /**
     * @Route("/{id}", name="cgv_delete", methods={"POST"})
     */
    public function delete(Request $request, CGV $cGV): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cGV->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cGV);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cgv_index', [], Response::HTTP_SEE_OTHER);
    }
}
