<?php

namespace App\Controller;

use App\Entity\Sectionnosservices;
use App\Form\SectionnosservicesType;
use App\Repository\SectionnosservicesRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sectionnosservices")
 */
class SectionnosservicesController extends AbstractController
{
    /**
     * @Route("/", name="sectionnosservices_index", methods={"GET"})
     */
    public function index(SectionnosservicesRepository $sectionnosservicesRepository): Response
    {
        return $this->render('sectionnosservices/index.html.twig', [
            'sectionnosservices' =>$sectionnosservicesRepository->findAll() ,
            'controller_name' => 'Nos Services - Ease & Car',
            'var' => 'NosServices',
        ]);
    }

    /**
     * @Route("/new", name="sectionnosservices_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $sectionnosservice = new Sectionnosservices();
        $form = $this->createForm(SectionnosservicesType::class, $sectionnosservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $sectionnosservice->setImage($file_name);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sectionnosservice);
            $entityManager->flush();

            return $this->redirectToRoute('sectionnosservices_index', [
                'controller_name' => 'Nos Services - Ease & Car',
                'var' => 'NosServices',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectionnosservices/new.html.twig', [
            'sectionnosservice' => $sectionnosservice,
            'form' => $form,
            'controller_name' => 'Nos Services - Ease & Car',
            'var' => 'NosServices',
        ]);
    }

    /**
     * @Route("/{id}", name="sectionnosservices_show", methods={"GET"})
     */
    public function show(Sectionnosservices $sectionnosservice): Response
    {
        return $this->render('sectionnosservices/show.html.twig', [
            'sectionnosservice' => $sectionnosservice,
            'controller_name' => 'Nos Services - Ease & Car',
            'var' => 'NosServices',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sectionnosservices_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sectionnosservices $sectionnosservice, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(SectionnosservicesType::class, $sectionnosservice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $sectionnosservice->setImage($file_name);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sectionnosservices_index', [
                'controller_name' => 'Nos Services - Ease & Car',
                'var' => 'NosServices',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sectionnosservices/edit.html.twig', [
            'sectionnosservice' => $sectionnosservice,
            'form' => $form,
            'controller_name' => 'Nos Services - Ease & Car',
            'var' => 'NosServices',
        ]);
    }

    /**
     * @Route("/{id}", name="sectionnosservices_delete", methods={"POST"})
     */
    public function delete(Request $request, Sectionnosservices $sectionnosservice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sectionnosservice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sectionnosservice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sectionnosservices_index', [
            'controller_name' => 'Nos Services - Ease & Car',
            'var' => 'NosServices',
        ], Response::HTTP_SEE_OTHER);
    }
}
