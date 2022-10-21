<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\DetailsFacture;
use App\Entity\Devis;
use App\Entity\Facture;
use App\Entity\Notes;
use App\Form\DevisType;
use App\Form\NotesType;
use App\Repository\ClientRepository;
use App\Repository\DetailsDevisRepository;
use App\Repository\DevisRepository;
use App\Repository\EaseandcarRepository;
use App\Repository\NotesRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/devis")
 */
class DevisController extends AbstractController
{

    /**
     * @Route("/", name="devis_index")
     */
    public function index(Request $request, DevisRepository $devisRepository, EaseandcarRepository $easeandcarRepository, ClientRepository $clientRepository,UserRepository $userRepository, \Swift_Mailer $mailer): Response
    {
        $notif = [];
  
        $notiff = $userRepository->findBy(['notification'=>true]);
        for ($i=0; $i < sizeof($notiff) ; $i++) { 
            $notif[] = $notiff[$i]->getEmail();
        }
        
        $devis = new Devis();
        $form = $this->createForm(DevisType::class, $devis)
        ->add('consentement', CheckboxType::class, [
            'required' => true,
            'label' => "J'autorise ce site à conserver mes données transmises via ce formulaire.",
        ]);
        $form->handleRequest($request);
        if ($form->getData()->getConsentement()==true) {
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
    
                $portable = $devis->getNumeroTel();
                $mail = $devis->getAdresseEmail();
                $societe = $devis->getNomEntreprise();
                $adresse = $devis->getAdresseSiege();
    
                $entityManager = $this->getDoctrine()->getManager();
                $data->setStatut("en attente");
                $data->setTVA("20");
                $data->setEaseCar($easeandcarRepository->findOneBy(['id' => 1]));
                
                $data->setCreatedAt(new DateTimeImmutable());
    
                $client = new Client();
                $client->setPortable($portable);
                $client->setMail($mail);
                $client->setSociete($societe);
                $client->setAdresse($adresse);
                  
                $recupMail = $clientRepository->findOneByMail($mail);
                if (!$recupMail) {
                    $entityManager->persist($client);
                    $entityManager->flush();
                }
    
                $data->setClient($clientRepository->findOneBy(['mail' => $mail]));
               /*  $entityManager->persist($client);
                $entityManager->flush(); */
    
                $entityManager->persist($data);
                $entityManager->flush();
                            
                $client = (new \Swift_Message('[Ease & Car] Message de confirmation'))
                ->setFrom('mintiontt1@gmail.com')
                ->setTo($data->getAdresseEmail())
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'emails/index.html.twig'
                    ),
                    'text/html'
                );
                $mailer->send($client);
                
                $admin = (new \Swift_Message("[Ease & Car] Message de d'alerte"))
                ->setFrom($data->getAdresseEmail())
                ->setTo($notif)
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'emails/contact.html.twig',
                    ),
                    'text/html'
                );
                $mailer->send($admin);
    
                /*return $this->redirectToRoute('devis_index', [], Response::HTTP_SEE_OTHER);*/
                return $this->render('emails/notif.html.twig',[
                    'controller_name' => 'Devis - Ease & Car',
                    'var' => 'devis',
                ])  ;     
            }
        }
       
            
        return $this->render('devis/index.html copy.twig', [
            
            'devis' => $devisRepository->findAll(),
            'controller_name' => 'Devis - Ease & Car',
            'var' => 'devis',
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/liste/{filter?}", name="devis_liste")
     */
    public function liste(DevisRepository $devisRepository, Request $request, PaginatorInterface $paginator): Response
    {
        /* return $this->render('devis/show.html.twig', [
            'devi' => $devi,
        ]); */
        //$session = new Session();
        if($request->query->get("form") != null){
            $value = $request->query->get("form")['filter'];
        }else{
            $value = null;
        }
        $form = $this->createFormBuilder()
            ->add('filter',SearchType::class,[
                'attr' => [
                    'name' => 'filter',
                    'placeholder' => "Nom de l'entreprise",
                ],
                'data' => $value,
            ])
            ->getForm();
        $form->handleRequest($request);   
        $filter = $request->query->get("form");
        //$value = $session->get('filter', []);
        /* if($filter == null){
            $filter = $request->query->set("filter", $request->query->get("filter"));
            $value = $filter;
            //$session->set('filter', $filter);
        } */
        
        $page = $request->query->get('page',1);
        $user = $this->getUser()->getRoles();
        $useremail = $this->getUser()->getEmail();
        
        if($user[0] == "ROLE_USER" OR $user[0] == "ROLE_COMMU"){
            $donnees = $devisRepository->findBy(['adresseEmail' => $useremail], ['createdAt' => 'desc']);
            $devis = $paginator->paginate(
                $donnees,
                $request->query->getInt('page', 1),
                10
            );
        }
        else {
            if ($filter != null) {
                $donnees = $devisRepository->findBy(['nomEntreprise' => $filter], ['createdAt' => 'desc']);
                $devis = $paginator
                ->paginate(
                    $donnees,
                    $page,
                    10
                );
        
            }else{
                $donnees = $devisRepository->findBy([], ['createdAt' => 'desc']);
                $devis = $paginator
                ->paginate(
                    $donnees,
                    $page,
                    10
                );
                }
            }
        $request->query->set("filter", $request->query->get("filter"));
        return $this->render('devis/liste.html.twig', [
            'devis' => $devis,
            'controller_name' => 'Devis - Ease & Car',
            'var' => 'devis',
            'data' => $donnees,
            'filter' => $filter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/web", name="devis_car")
     */
    public function generer(Devis $devis, DetailsDevisRepository $detailsDevisRepository): Response
    {
        
        $data = $detailsDevisRepository->findBy(['Devis' => $devis]);
        $tht = 0;
        for ($i=0; $i < sizeof($data); $i++) { 
            $tht += $data[$i]->getTarifHT();
        }
        $tva = $tht * $devis->getTVA() / 100;
        $ttc = $tht + $tva;
        if ($devis->getNumDevis() == null) {
            $devis->setNumDevis($devis->getCreatedAt()->format('ymd').$devis->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($devis);
            $entityManager->flush();
            return $this->render('devis/Devis.html.twig', [
                'devisCar' => $devis,
                'tht' => $tht,
                'TVA' => $tva,
                'TTC' => $ttc,
                'var' => '',
            ]);
        }
        return $this->render('devis/Devis.html.twig', [
            'devisCar' => $devis,
            'tht' => $tht,
            'TVA' => $tva,
            'TTC' => $ttc,
            'var' => '',
        ]);
    }

    /**
     * @Route("/new", name="devis_new", methods={"GET","POST"})
     */
    public function new(Request $request, EaseandcarRepository $easeandcarRepository, ClientRepository $clientRepository): Response
    {
        $devis = new Devis();
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $devis->setStatut("en attente");
            $devis->setTVA("20");
            $devis->setEaseCar($easeandcarRepository->findOneBy(['id' => 1]));
            $devis->setCreatedAt(new DateTimeImmutable());
            $devis->setConsentement(true);
            $entityManager = $this->getDoctrine()->getManager();

            $client = new Client();
            $client->setPortable($devis->getNumeroTel());
            $client->setMail($devis->getAdresseEmail());
            $client->setSociete($devis->getNomEntreprise());
            $client->setAdresse($devis->getAdresseSiege());

                
            $recupMail = $clientRepository->findOneByMail($devis->getAdresseEmail());
            if (!$recupMail) {
                $entityManager->persist($client);
                $entityManager->flush();
            }

            $devis->setClient($clientRepository->findOneBy(['mail' => $devis->getAdresseEmail()]));
            $entityManager->persist($devis);
            $entityManager->flush();
            return $this->redirectToRoute('devis_liste', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('devis/new.html.twig', [
            'devi' => $devis,
            'form' => $form,
            'var' => 'devis',
            'var'=>'easeandcar',
        ]);
    }

    /**
     * @Route("/{id}", name="devis_show", methods={"GET"})
     */
    public function show(Devis $devi, NotesRepository $notesRepository): Response
    {
       
        return $this->render('devis/show.html.twig', [
            'devi' => $devi,
            'var' => 'devis',
            'notes' => $notesRepository->findBy(['relationDevis' => $devi]),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="devis_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request, Devis $devis): Response
    {
        $form = $this->createForm(DevisType::class, $devis)
        ->add('statut', ChoiceType::class, [
            "choices" => [
                "en attente" => "en attente",
                "en cours" => "en cours",
                "valider" => "validé",
                "refuser" => "refusé",
            ],
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($devis);
            $entityManager->flush();
            return $this->redirectToRoute('devis_liste', [], Response::HTTP_SEE_OTHER);
        }
        $note = new Notes();
        $form1 = $this->createForm(NotesType::class, $note);
        $form1->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $data = $form1->getData();
            $data->setRelation($devis);
            $data->setCreatedAt(new DateTimeImmutable());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('devis_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/edit.html.twig', [
            'devi' => $devis,
            'form' => $form->createView(),
            'form1' => $form1->createView(),
            'var' => 'devis',
        ]);
    }

    /**
     * @Route("/{id}/modifierdetails", name="modifierDetails", requirements={"id"="\d+"})
     */
    public function modifierDetails(Request $request, Devis $devis): Response
    {
        $form = $this->createFormBuilder()
        ->add('numDevis', TextType::class, [
            'data' => $devis->getNumDevis(),
        ])
        ->add('createdAt', DateType::class, [
            'input' => 'datetime_immutable',
            'widget' =>'single_text',
            'required' =>true,
            'label' => 'Date de création',
            'data' => $devis->getCreatedAt(),
        ])
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $devis->setCreatedAt($form->getData()['createdAt']);
            $devis->setNumDevis($form->getData()['numDevis']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($devis);
            $entityManager->flush();
            return $this->redirectToRoute('devis_car', ['id' => $devis->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/modifierDetails.html.twig', [
            'devi' => $devis,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifiertva", name="modifierTVA", requirements={"id"="\d+"})
     */
    public function modifierTVA(Request $request, Devis $devis): Response
    {
        $form = $this->createFormBuilder()
        ->add('TVA', TextType::class,[
            'label' => 'TVA',
            'data' => $devis->getTVA(),
        ])
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $devis->setTVA($form->getData()['TVA']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($devis);
            $entityManager->flush();
            return $this->redirectToRoute('devis_car', ['id' => $devis->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/modifierDetails.html.twig', [
            'devi' => $devis,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/genererfacture", name="genererFacture", requirements={"id"="\d+"})
     */
    public function genererFacture(Devis $devis, DetailsDevisRepository $detailsDevisRepository): Response
    {
        
        $data = $detailsDevisRepository->findBy(['Devis' => $devis]);
        $tht = 0;
        for ($i=0; $i < sizeof($data); $i++) { 
            $tht += $data[$i]->getTarifHT();
        }

        $tva = $tht * $devis->getTVA() / 100;
        $ttc = $tht + $tva;
        $facture = new Facture;
        $facture->setNumFacture($devis->getNumDevis());
        
        $facture->setDate(new DateTimeImmutable());
        $facture->setRaisonSociale($devis->getEaseCar()->getRaisonSociale());
        $facture->setAdresse($devis->getEaseCar()->getAdresse());
        $facture->setTelephone($devis->getEaseCar()->getTelephone());
        $facture->setNom($devis->getNomEntreprise());
        $facture->setAdresseClient($devis->getAdresseSiege());
        $facture->setTelephoneClient($devis->getNumeroTel());
        $facture->setEtat("A encaisser");
        $facture->setPrixHt($tht);
        $facture->setPrixTtc($ttc); 
        $facture->setTVA('20');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($facture);
        $entityManager->flush();
        
        for ($i=0; $i < sizeof($data); $i++) { 
            $detail = new DetailsFacture();
            $detail->setReference($data[$i]->getReference());
            $detail->setType($data[$i]->getType());
            $detail->setDebut($data[$i]->getDebut());
            $detail->setFin($data[$i]->getFin());
            $detail->setNombreVehicules($data[$i]->getNombreVehicules());
            $detail->setKilometrage($data[$i]->getKilometrage());
            $detail->setTarifHT($data[$i]->getTarifHT());
            $detail->setFacture($facture);
            $entityManager->persist($detail);
            $entityManager->flush();
            return $this->redirectToRoute('devis_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('devis_liste', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * @Route("/{id}/modifier-validit", name="modifier_validit", requirements={"id"="\d+"})
     */
    public function modifValidite(Request $request, Devis $devis): Response
    {
        $form = $this->createFormBuilder()
        ->add('delaiDevis', TextType::class,[
            'label' => 'délai de devis',
            'data' => $devis->getDelaiDevis(),
        ])
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $devis->setDelaiDevis($form->getData()['delaiDevis']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($devis);
            $entityManager->flush();
            return $this->redirectToRoute('devis_car', ['id' => $devis->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/delaiDevis.html.twig', [
            'devis' => $devis,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/modifiercondition", name="modifierCondition", requirements={"id"="\d+"})
     */
    public function modifierCondition(Request $request, Devis $devis): Response
    {
        $form = $this->createFormBuilder()
        ->add('conditionReglement', TextType::class,[
            'label' => 'Conditions de Réglement',
            'data' => $devis->getConditionReglement(),
        ])
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $devis->setConditionReglement($form->getData()['conditionReglement']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($devis);
            $entityManager->flush();
            return $this->redirectToRoute('devis_car', ['id' => $devis->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->render('devis/modifierDetails.html.twig', [
            'devi' => $devis,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="devis_delete", methods={"POST"})
     */
    public function delete(Request $request, Devis $devi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$devi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($devi);
            $entityManager->flush();
        }
        return $this->redirectToRoute('devis_liste', [], Response::HTTP_SEE_OTHER);
    }

}

