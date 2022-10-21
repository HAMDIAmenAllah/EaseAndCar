<?php

namespace App\Controller;

use App\Entity\Actualit;
use App\Form\ActualitType;
use App\Repository\ActualitRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actualit")
 */
class ActualitController extends AbstractController
{
    /**
     * @Route("/", name="actualit_index", methods={"GET"})
     */
    public function index(ActualitRepository $actualitRepository): Response
    {
        return $this->render('actualit/index.html.twig', [
            'actualits' => $actualitRepository->findAll(),
            'var' => 'actualité',
            'controller_name' => 'Actualité - Ease & car',
        ]);

    }/**
     * @Route("/actualit/liste", name="actualit_liste", methods={"GET"})
     */
    public function liste(ActualitRepository $actualitRepository): Response
    {
        return $this->render('actualit/liste.html.twig', [
            'actualits' => $actualitRepository->findAll(),
            'var' => 'actualité',
        ]);
    }

    /**
     * @Route("/new", name="actualit_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
    
        $actualit = new Actualit();
        $form = $this->createForm(ActualitType::class, $actualit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $actualit->setImage($file_name);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actualit);
            $entityManager->flush();

            return $this->redirectToRoute('actualit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualit/new.html.twig', [
            'actualit' => $actualit,
            'form' => $form,
            'var' => 'actualité',
        ]);
    }

    /**
     * @Route("/{id}", name="actualit_show", methods={"GET"})
     */
    public function show(Actualit $actualit): Response
    {
        return $this->render('actualit/show.html.twig', [
            'actualit' => $actualit,
            'var' => 'actualité',
        ]);
    }

    /**
     * @Route("/{id}/edit",  requirements={"id"="1"}, name="actualit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Actualit $actualit, FileUploader $fileUploader, ActualitRepository $actualitRepository ): Response
    {
        $form = $this->createForm(ActualitType::class, $actualit);
        $form->handleRequest($request);

       

        if ($form->isSubmitted() && $form->isValid()) {

            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $actualit->setImage($file_name);
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('actualit_edit', ["id" => 1], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualit/edit.html.twig', [
            'actualit' => $actualit,
            'form' => $form,
            'var' => 'actualité',
            /* 'actualité'=> $actualitRepository->findOneBy(['id' => 1]), */

        ]);
    }

    /**
     * @Route("/{id}", name="actualit_delete", methods={"POST"})
     */
    public function delete(Request $request, Actualit $actualit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actualit_index', [], Response::HTTP_SEE_OTHER);
    }
}
