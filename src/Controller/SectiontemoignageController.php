<?php

namespace App\Controller;

use App\Entity\Sectiontemoignage;
use App\Form\SectiontemoignageType;
use App\Repository\SectiontemoignageRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sectiontemoignage")
 */
class SectiontemoignageController extends AbstractController
{
    /**
     * @Route("/", name="sectiontemoignage_index", methods={"GET"})
     */
    public function index(SectiontemoignageRepository $sectiontemoignageRepository): Response
    {
        return $this->render('sectiontemoignage/index.html.twig', [
            'sectiontemoignages' => $sectiontemoignageRepository->findAll(),
            'controller_name' => 'Temoignage - Ease & Car',
            'var' => 'Temoignage',
        ]);
    }

    /**
     * @Route("/new", name="sectiontemoignage_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $sectiontemoignage = new Sectiontemoignage();
        $form = $this->createForm(SectiontemoignageType::class, $sectiontemoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $sectiontemoignage->setImage($file_name);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sectiontemoignage);
            $entityManager->flush();

            return $this->redirectToRoute('sectiontemoignage_index', [
                'controller_name' => 'Temoignage - Ease & Car',
                'var' => 'Temoignage',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectiontemoignage/new.html.twig', [
            'sectiontemoignage' => $sectiontemoignage,
            'form' => $form,
            'controller_name' => 'Temoignage - Ease & Car',
            'var' => 'Temoignage',
        ]);
    }

    /**
     * @Route("/{id}", name="sectiontemoignage_show", methods={"GET"})
     */
    public function show(Sectiontemoignage $sectiontemoignage): Response
    {
        return $this->render('sectiontemoignage/show.html.twig', [
            'sectiontemoignage' => $sectiontemoignage,
            'controller_name' => 'Temoignage - Ease & Car',
            'var' => 'Temoignage',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sectiontemoignage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sectiontemoignage $sectiontemoignage, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(SectiontemoignageType::class, $sectiontemoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $sectiontemoignage->setImage($file_name);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sectiontemoignage_index', [
                'controller_name' => 'Temoignage - Ease & Car',
                'var' => 'Temoignage',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectiontemoignage/edit.html.twig', [
            'sectiontemoignage' => $sectiontemoignage,
            'form' => $form,
            'controller_name' => 'Temoignage - Ease & Car',
            'var' => 'Temoignage',
        ]);
    }

    /**
     * @Route("/{id}", name="sectiontemoignage_delete", methods={"POST"})
     */
    public function delete(Request $request, Sectiontemoignage $sectiontemoignage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sectiontemoignage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sectiontemoignage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sectiontemoignage_index', [
            'controller_name' => 'Temoignage - Ease & Car',
            'var' => 'Temoignage',
        ], Response::HTTP_SEE_OTHER);
    }
}
