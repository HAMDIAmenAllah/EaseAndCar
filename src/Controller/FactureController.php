<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Notes;
use App\Form\FactureType;
use App\Form\NotesType;
use App\Repository\DetailsFactureRepository;
use App\Repository\FactureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facture")
 */
class FactureController extends AbstractController
{
    /**
     * @Route("/", name="facture_index", methods={"GET"})
     */
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('facture/liste.html.twig', [
            'factures' => $factureRepository->findAll(),
            'var' => 'facture',
        ]);
    }

    /**
     * @Route("/new", name="facture_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{id}/web", name="afficher_facture", methods={"GET"})
     */
    public function afficher(Facture $facture, DetailsFactureRepository $detailsFactureRepository): Response
    {
        $data = $detailsFactureRepository->findBy(['facture' => $facture]);
        $tht = 0;
        for ($i=0; $i < sizeof($data); $i++) { 
            $tht += $data[$i]->getTarifHT();
        }
        $tva = $tht * $facture->getTVA() / 100;
        $ttc = $tht + $tva;
        $facture->setPrixTtc($ttc);
        $facture->setPrixHt($ttc);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($facture);
        $entityManager->flush();
        return $this->render('facture/facture.html.twig', [
            'facture' => $facture,
            'var' => '',
        ]);
    }

    /**
     * @Route("/{id}/edit", name="facture_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Facture $facture): Response
    {
        $form = $this->createForm(FactureType::class, $facture)
        ->add('etat', ChoiceType::class, [
            "choices" => [
                "Brouillon" => "Brouillon",
                "A encaisser" => "A encaisser",
                "Archivé" => "Archivé",
                "En retard" => "En retard",  
            ],
            'expanded' => true,
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
        }
        $note = new Notes();
        $form1 = $this->createForm(NotesType::class, $note);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'var' => $facture,
            'form' => $form->createView(),
            'form1' => $form1->createView(),
        ]);
    }

     /**
     * @Route("/{id}/modif-societe", name="modif_societe")
     */
    public function modifierSociete(Request $request, Facture $facture): Response
    {
        $form = $this->createFormBuilder()
        ->add('raisonSociale', TextType::class, ['data'=>$facture->getRaisonSociale(),])
        ->add('adresse', TextType::class, ['data'=>$facture->getAdresse(),])
        ->add('telephone', TextType::class, ['data'=>$facture->getTelephone(),])
        ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $facture->setRaisonsociale($data['raisonSociale']);
            $facture->setAdresse($data['adresse']);
            $facture->setTelephone($data['telephone']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();
            

            return $this->redirectToRoute('afficher_facture', ['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('facture/modifSociete.htm.twig', [
            'facture' => $facture,
            'var' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modif-facture", name="modif_facture")
     */
    public function modifierFacture(Request $request, Facture $facture): Response
    {
        $form = $this->createFormBuilder()
        ->add('numFacture' , TextType::class, ['data'=>$facture->getNumFacture(),])
        ->add('date', DateType::class,[
            'data'=>$facture->getDate(),
            'widget'=>'single_text',

        ])
        ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $facture->setNumFacture($data['numFacture']);
            $facture->setDate($data['date']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();
            

            return $this->redirectToRoute('afficher_facture', ['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('facture/modifSociete.htm.twig', [
            'facture' => $facture,
            'var' => $facture,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/modif-client", name="modif_client")
     */
    public function modifierClient(Request $request, Facture $facture): Response
    {
        $form = $this->createFormBuilder()
        ->add('nom', TextType::class, ['data' => $facture->getNom(),])
        ->add('adresseClient', TextType::class, ['data' => $facture->getAdresseClient(),])
        ->add('telephoneClient', TextType::class, ['data' => $facture->getTelephoneClient(),])

        ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $facture->setNom($data['nom']);
            $facture->setAdresseClient($data['adresseClient']);
            $facture->setTelephoneClient($data['telephoneClient']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();
            

            return $this->redirectToRoute('afficher_facture', ['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('facture/modifClient.html.twig', [
            'facture' => $facture,
            'var' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier-tva", name="modifier_TVA", requirements={"id"="\d+"})
     */
    public function modifTVA(Request $request, Facture $facture): Response
    {
        $form = $this->createFormBuilder()
        ->add('TVA', TextType::class,[
            'label' => 'TVA',
            'data' => $facture->getTVA(),
        ])
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $facture->setTVA($form->getData()['TVA']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();
            return $this->redirectToRoute('afficher_facture', ['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/modifTva.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier-paiement", name="modifier_paiement", requirements={"id"="\d+"})
     */
    public function modifierpaiement(Request $request, Facture $facture): Response
    {
        $form = $this->createFormBuilder()
        ->add('delaiPaiment', TextType::class,[
            'label' => 'délai de paiement',
            'data' => $facture->getDelaiPaiement(),
        ])
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $facture->setDelaiPaiement($form->getData()['delaiPaiment']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();
            return $this->redirectToRoute('afficher_facture', ['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/modifierpaiement.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier-validite", name="modifier_validite", requirements={"id"="\d+"})
     */
    public function modifValidite(Request $request, Facture $facture): Response
    {
        $form = $this->createFormBuilder()
        ->add('delaiFacture', TextType::class,[
            'label' => 'délai de la Facture',
            'data' => $facture->getDelaiFacture(),
        ])
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $facture->setDelaiFacture($form->getData()['delaiFacture']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();
            return $this->redirectToRoute('afficher_facture', ['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/delaiFacture.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifier-Condition", name="modifier_Condition", requirements={"id"="\d+"})
     */
    public function modifCondition(Request $request, Facture $facture): Response
    {
        $form = $this->createFormBuilder()
        ->add('conditionReglement', TextType::class,[
            'label' => 'conditions de Réglement',
            'data' => $facture->getConditionReglement(),
        ])
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $facture->setConditionReglement($form->getData()['conditionReglement']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($facture);
            $entityManager->flush();
            return $this->redirectToRoute('afficher_facture', ['id' => $facture->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/condition.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @Route("/{id}", name="facture_delete", methods={"POST"})
     */
    public function delete(Request $request, Facture $facture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
