<?php

namespace App\Controller;

use App\Entity\FAQ;
use App\Form\FAQType;
use App\Repository\FAQRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/faq")
 */
class FAQController extends AbstractController
{
    /**
     * @Route("/", name="faq_index", methods={"GET"})
     */
    public function index(FAQRepository $fAQRepository): Response
    {
        return $this->render('faq/index.html.twig', [
            'faqs' => $fAQRepository->findAll(),
            'controller_name' => 'FAQ - Ease & Car',
            'var' => 'FAQ',
        ]);
    }
    /**
     * @Route("/liste", name="faq_liste", methods={"GET"})
     */
    public function liste(FAQRepository $fAQRepository): Response
    {
        return $this->render('faq/liste.html.twig', [
            'faqs' => $fAQRepository->findAll(),
            'controller_name' => 'FAQ - Ease & Car',
            'var' => 'FAQ',
        ]);
    }

    /**
     * @Route("/new", name="faq_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fAQ = new FAQ();
        $form = $this->createForm(FAQType::class, $fAQ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fAQ);
            $entityManager->flush();

            return $this->redirectToRoute('faq_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('faq/new.html.twig', [
            'faq' => $fAQ,
            'form' => $form,
            'var' => 'FAQ',
        ]);
    }

    /**
     * @Route("/{id}", name="faq_show", methods={"GET"})
     */
    public function show(FAQ $fAQ): Response
    {
        return $this->render('faq/show.html.twig', [
            'faq' => $fAQ,
            'var' => 'FAQ',
        ]);
    }

    /**
     * @Route("/{id}/edit", requirements={"id"="1"}, name="faq_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FAQ $fAQ): Response
    {
        $form = $this->createForm(FAQType::class, $fAQ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('faq_edit', ["id" => 1,], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('faq/edit.html.twig', [
            'faq' => $fAQ,
            'form' => $form,
            'var' => 'FAQ',
        ]);
    }

    /**
     * @Route("/{id}", name="faq_delete", methods={"POST"})
     */
    public function delete(Request $request, FAQ $fAQ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fAQ->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fAQ);
            $entityManager->flush();
        }

        return $this->redirectToRoute('faq_liste', [], Response::HTTP_SEE_OTHER);
    }
}
