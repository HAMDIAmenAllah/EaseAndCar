<?php

namespace App\Controller;

use App\Entity\Commentcamarche;
use App\Form\CommentcamarcheType;
use App\Repository\CommentcamarcheRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentcamarche")
 */
class CommentcamarcheController extends AbstractController
{
    /**
     * @Route("/", name="commentcamarche_index", methods={"GET"})
     */
    public function index(CommentcamarcheRepository $commentcamarcheRepository): Response
    {
        return $this->render('commentcamarche/index.html.twig', [
            'commentcamarches' => $commentcamarcheRepository->findAll(),
            'controller_name' => 'Comment ça marche - Ease & Car',
            'var' => 'CommentçaMarche',
        ]);
    }

    /**
     * @Route("/new", name="commentcamarche_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $commentcamarche = new Commentcamarche();
        $form = $this->createForm(CommentcamarcheType::class, $commentcamarche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $commentcamarche->setImage($file_name);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentcamarche);
            $entityManager->flush();

            return $this->redirectToRoute('commentcamarche_index', [
                'controller_name' => 'Comment ça marche - Ease & Car',
                'var' => 'CommentçaMarche',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentcamarche/new.html.twig', [
            'commentcamarche' => $commentcamarche,
            'form' => $form,
            'controller_name' => 'Comment ça marche - Ease & Car',
            'var' => 'CommentçaMarche',
        ]);
    }

    /**
     * @Route("/{id}", name="commentcamarche_show", methods={"GET"})
     */
    public function show(Commentcamarche $commentcamarche): Response
    {
        return $this->render('commentcamarche/show.html.twig', [
            'commentcamarche' => $commentcamarche,
            'controller_name' => 'Comment ça marche - Ease & Car',
            'var' => 'CommentçaMarche',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commentcamarche_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commentcamarche $commentcamarche, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(CommentcamarcheType::class, $commentcamarche);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file1 = $form['image']->getData();
            if ($file1) {
                $file_name = $fileUploader->upload($file1);
                $commentcamarche->setImage($file_name);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commentcamarche_index', [
                'controller_name' => 'Comment ça marche - Ease & Car',
                'var' => 'CommentçaMarche',
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentcamarche/edit.html.twig', [
            'commentcamarche' => $commentcamarche,
            'form' => $form,
            'controller_name' => 'Comment ça marche - Ease & Car',
            'var' => 'CommentçaMarche',
        ]);
    }

    /**
     * @Route("/{id}", name="commentcamarche_delete", methods={"POST"})
     */
    public function delete(Request $request, Commentcamarche $commentcamarche): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentcamarche->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentcamarche);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commentcamarche_index', [
            'controller_name' => 'Comment ça marche - Ease & Car',
            'var' => 'CommentçaMarche',
        ], Response::HTTP_SEE_OTHER);
    }
}
