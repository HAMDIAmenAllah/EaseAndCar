<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Devis;
use App\Form\ContratType;
use App\Repository\ContratRepository;
use App\Repository\DetailsDevisRepository;
use App\Repository\EaseandcarRepository;
use App\Repository\GalerieRepository;
use App\Repository\NotesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;

/**
 * @Route("/contrat")
 */
class ContratController extends AbstractController
{
    /**
     * @Route("/", name="contrat_index", methods={"GET"})
     */
    public function index(ContratRepository $contratRepository): Response
    {
        return $this->render('contrat/index.html.twig', [
            'contrats' => $contratRepository->findAll(),
            'var' => 'contrat',
        ]);
    }

    /**
     * @Route("/new", name="contrat_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contrat = new Contrat();
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contrat);
            $entityManager->flush();

            return $this->redirectToRoute('contrat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contrat/new.html.twig', [
            'contrat' => $contrat,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contrat_show", methods={"GET"})
     */
    public function show(Contrat $contrat): Response
    {
        return $this->render('contrat/show.html.twig', [
            'contrat' => $contrat,
        ]);
    }

    /**
     * @Route("/{id}/web", name="afficher_contrat", methods={"GET"})
     */
    public function afficher(Contrat $contrat): Response
    {
       /*  $data = $detailsContratRepository->findBy(['contrat' => $contrat]);
        $tht = 0;
        for ($i=0; $i < sizeof($data); $i++) { 
            $tht += $data[$i]->getTarifHT();
        }
        $tva = $tht * $contrat->getTVA() / 100;
        $ttc = $tht + $tva;
        $contrat->setPrixTtc($ttc);
        $contrat->setPrixHt($ttc); */
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($contrat);
        $entityManager->flush();
        return $this->render('contrat/contrat.html.twig', [
            'contrat' => $contrat,
            'var' => '',
        ]);
    }


    /**
     * @Route("/{id}/edit", name="contrat_edit", )
     */
    public function edit(Request $request, Contrat $contrat, GalerieRepository $galerieRepository): Response
    {
        $tht = $contrat->getTarifHT();
        $tva = $tht * $contrat->getTVA() / 100;
        $ttc = $tht + $tva;
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('contrat_edit', ['id'=>$contrat->getId(),], Response::HTTP_SEE_OTHER);
           
        }
        return $this->render('contrat/edit.html.twig', [
            'galeries' => $galerieRepository->findBy(['contrat'=>$contrat->getId()]),
            'depart' => $galerieRepository->findBy(['aller'=>true,'contrat'=>$contrat->getId()]),
            'retour' => $galerieRepository->findBy(['retour'=>true,'contrat'=>$contrat->getId()]),
            'contrat' => $contrat,
            'form' => $form->createView(),         
            'tht' => $tht,
            'TVA' => $tva,
            'TTC' => $ttc,
            'var' => '',
        ]);
    }

    /**
     * @Route("/{id}", name="contrat_delete", methods={"POST"})
     */
    public function delete(Request $request, Contrat $contrat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contrat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contrat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contrat_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/creer-contrat", name="creer_contrat", requirements={"id"="\d+"})
     */
    public function creerContrat( DetailsDevisRepository $detailsDevisRepository, NotesRepository $notesRepository, EaseandcarRepository $easeandcarRepository, Devis $devis): Response
    {
        $detailsDevis = $detailsDevisRepository->findBy(['Devis'=>$devis]);
        foreach ($detailsDevis as $value) {
            $contrat = new Contrat();
            $contrat->setNumContrat($devis->getNumDevis().$value->getReference());       
            $contrat->setDate(new DateTimeImmutable());
            $contrat->setRaisonSociale($devis->getEaseCar()->getRaisonSociale());
            $contrat->setAdresse($devis->getEaseCar()->getAdresse());
            $contrat->setTelephone($devis->getEaseCar()->getTelephone());
            $contrat->setNom($devis->getNomEntreprise());
            $contrat->setAdresseClient($devis->getAdresseSiege());
            $contrat->setTelephoneClient($devis->getNumeroTel());
            $contrat->setEtat("non signé"); 
            $contrat->setTVA('20');
            $contrat->setNumTVA($devis->getEaseCar()->getNumTVA());
            $contrat->setNom($devis->getClient()->getNom());
            $contrat->setPrenom($devis->getClient()->getPrenom());
            $contrat->setSiret($devis->getEaseCar()->getSiret());
            $contrat->setFormeJuridique($devis->getEaseCar()->getFormeJuridique());
            $contrat->setRCS($devis->getEaseCar()->getRCS());
            $contrat->setSocieteClient($devis->getClient()->getSociete());
            /* détails devis */
            $contrat->setReference($value->getReference());
            $contrat->setType($value->getType());
            $contrat->setDebut($value->getDebut());
            $contrat->setFin($value->getFin());
            $contrat->setNombreVehicules($value->getNombreVehicules());
            $contrat->setKilometrage($value->getKilometrage());
            $contrat->setTarifHT($value->getTarifHT()); 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contrat);
            $entityManager->flush();           
        }
        return $this->redirectToRoute('devis_liste', [], Response::HTTP_SEE_OTHER);
    
    }
    
}
