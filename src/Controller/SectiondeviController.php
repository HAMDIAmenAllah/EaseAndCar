<?php

namespace App\Controller;

use App\Entity\Sectiondevi;
use App\Form\SectiondeviType;
use App\Repository\SectiondeviRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sectiondevis")
 */
class SectiondeviController extends AbstractController
{
    /**
     * @Route("/", name="sectiondevi_index", methods={"GET"})
     */
    public function index(SectiondeviRepository $sectiondeviRepository): Response
    {
        return $this->render('sectiondevi/index.html.twig', [
            'sectiondevis' => $sectiondeviRepository->findAll(),
            'controller_name' => 'Section Devis - Ease & Car',
            'var' => 'Section Devis',
        ]);
    }

    /**
     * @Route("/new", name="sectiondevi_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $sectiondevi = new Sectiondevi();
        $form = $this->createForm(SectiondeviType::class, $sectiondevi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $sectiondevi->setImage($file_name);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sectiondevi);
            $entityManager->flush();

            return $this->redirectToRoute('sectiondevi_index', [
                'controller_name' => 'Section Devis - Ease & Car',
                'var' => 'Section Devis',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectiondevi/new.html.twig', [
            'sectiondevi' => $sectiondevi,
            'form' => $form,
            'controller_name' => 'Section Devis - Ease & Car',
            'var' => 'Section Devis',
        ]);
    }

    /**
     * @Route("/{id}", name="sectiondevi_show", methods={"GET"})
     */
    public function show(Sectiondevi $sectiondevi): Response
    {
        return $this->render('sectiondevi/show.html.twig', [
            'sectiondevi' => $sectiondevi,
            'controller_name' => 'Section Devis - Ease & Car',
            'var' => 'Section Devis',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sectiondevi_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sectiondevi $sectiondevi, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(SectiondeviType::class, $sectiondevi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $sectiondevi->setImage($file_name);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sectiondevi_index', [
                'controller_name' => 'Section Devis - Ease & Car',
                'var' => 'Section Devis',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectiondevi/edit.html.twig', [
            'sectiondevi' => $sectiondevi,
            'form' => $form,
            'controller_name' => 'Section Devis - Ease & Car',
            'var' => 'Section Devis',
        ]);
    }

    /**
     * @Route("/{id}", name="sectiondevi_delete", methods={"POST"})
     */
    public function delete(Request $request, Sectiondevi $sectiondevi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sectiondevi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sectiondevi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sectiondevi_index', [
            'controller_name' => 'Section Devis - Ease & Car',
            'var' => 'Section Devis',
        ], Response::HTTP_SEE_OTHER);
    }
}
