<?php

namespace App\Controller;

use App\Entity\Sectionnosengagements;
use App\Form\SectionnosengagementsType;
use App\Repository\SectionnosengagementsRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sectionnosengagements")
 */
class SectionnosengagementsController extends AbstractController
{
    /**
     * @Route("/", name="sectionnosengagements_index", methods={"GET"})
     */
    public function index(SectionnosengagementsRepository $sectionnosengagementsRepository): Response
    {
        return $this->render('sectionnosengagements/index.html.twig', [
            'sectionnosengagements' => $sectionnosengagementsRepository->findAll(),
            'controller_name' => 'Nos Engagements - Ease & Car',
            'var' => 'Engagements',
        ]);
    }

    /**
     * @Route("/new", name="sectionnosengagements_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $sectionnosengagement = new Sectionnosengagements();
        $form = $this->createForm(SectionnosengagementsType::class, $sectionnosengagement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $sectionnosengagement->setImage($file_name);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sectionnosengagement);
            $entityManager->flush();

            return $this->redirectToRoute('sectionnosengagements_index', [
                'controller_name' => 'Nos Engagements - Ease & Car',
                'var' => 'Engagements',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectionnosengagements/new.html.twig', [
            'sectionnosengagement' => $sectionnosengagement,
            'form' => $form,
            'controller_name' => 'Nos Engagements - Ease & Car',
            'var' => 'Engagements',
        ]);
    }

    /**
     * @Route("/{id}", name="sectionnosengagements_show", methods={"GET"})
     */
    public function show(Sectionnosengagements $sectionnosengagement): Response
    {
        return $this->render('sectionnosengagements/show.html.twig', [
            'sectionnosengagement' => $sectionnosengagement,
            'controller_name' => 'Nos Engagements - Ease & Car',
            'var' => 'Engagements',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sectionnosengagements_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sectionnosengagements $sectionnosengagement, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(SectionnosengagementsType::class, $sectionnosengagement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $sectionnosengagement->setImage($file_name);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sectionnosengagements_index', [
                'controller_name' => 'Nos Engagements - Ease & Car',
                'var' => 'Engagements',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectionnosengagements/edit.html.twig', [
            'sectionnosengagement' => $sectionnosengagement,
            'form' => $form,
            'controller_name' => 'Nos Engagements - Ease & Car',
            'var' => 'Engagements',
        ]);
    }

    /**
     * @Route("/{id}", name="sectionnosengagements_delete", methods={"POST"})
     */
    public function delete(Request $request, Sectionnosengagements $sectionnosengagement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sectionnosengagement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sectionnosengagement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sectionnosengagements_index', [
            'controller_name' => 'Nos Engagements - Ease & Car',
            'var' => 'Engagements',
        ], Response::HTTP_SEE_OTHER);
    }
}
