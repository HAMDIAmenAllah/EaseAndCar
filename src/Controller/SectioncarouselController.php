<?php

namespace App\Controller;

use App\Entity\Sectioncarousel;
use App\Form\SectioncarouselType;
use App\Repository\SectioncarouselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sectioncarousel")
 */
class SectioncarouselController extends AbstractController
{
    /**
     * @Route("/", name="sectioncarousel_index", methods={"GET"})
     */
    public function index(SectioncarouselRepository $sectioncarouselRepository): Response
    {
        return $this->render('sectioncarousel/index.html.twig', [
            'sectioncarousels' => $sectioncarouselRepository->findAll(),
            'controller_name' => 'Section Carousel - Ease & Car',
            'var' => 'Carousel',
        ]);
    }

    /**
     * @Route("/new", name="sectioncarousel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sectioncarousel = new Sectioncarousel();
        $form = $this->createForm(SectioncarouselType::class, $sectioncarousel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sectioncarousel);
            $entityManager->flush();

            return $this->redirectToRoute('sectioncarousel_index', [
                'controller_name' => 'Section Carousel - Ease & Car',
                'var' => 'Carousel',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectioncarousel/new.html.twig', [
            'sectioncarousel' => $sectioncarousel,
            'form' => $form,
            'controller_name' => 'Section Carousel - Ease & Car',
            'var' => 'Carousel',
        ]);
    }

    /**
     * @Route("/{id}", name="sectioncarousel_show", methods={"GET"})
     */
    public function show(Sectioncarousel $sectioncarousel): Response
    {
        return $this->render('sectioncarousel/show.html.twig', [
            'sectioncarousel' => $sectioncarousel,
            'controller_name' => 'Section Carousel - Ease & Car',
            'var' => 'Carousel',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sectioncarousel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sectioncarousel $sectioncarousel): Response
    {
        $form = $this->createForm(SectioncarouselType::class, $sectioncarousel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sectioncarousel_index', [
                'controller_name' => 'Section Carousel - Ease & Car',
                'var' => 'Carousel',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectioncarousel/edit.html.twig', [
            'sectioncarousel' => $sectioncarousel,
            'form' => $form,
            'controller_name' => 'Section Carousel - Ease & Car',
            'var' => 'Carousel',
        ]);
    }

    /**
     * @Route("/{id}", name="sectioncarousel_delete", methods={"POST"})
     */
    public function delete(Request $request, Sectioncarousel $sectioncarousel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sectioncarousel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sectioncarousel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sectioncarousel_index', [
            'controller_name' => 'Section Carousel - Ease & Car',
            'var' => 'Carousel',
        ], Response::HTTP_SEE_OTHER);
    }
}
