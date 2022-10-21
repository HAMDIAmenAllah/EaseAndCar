<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ClientRepository;
use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{

    /**
     * @Route("/", name="contact" )
     */
    public function index(\Swift_Mailer $mailer,  ContactRepository $contactRepository, 
ClientRepository $clientRepository,EntityManagerInterface $entityManager,UserRepository $userRepository, Request $request): Response
    { 
        $notif = [];
  
        $notiff = $userRepository->findBy(['notification'=>true]);
        for ($i=0; $i < sizeof($notiff) ; $i++) { 
            $notif[] = $notiff[$i]->getEmail();
        }
        
      /*   if (!$recupMail) {
            $entityManager->persist($client);
            $entityManager->flush();
        } */
        
        $contact = new Contact();
    
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {  
                
                $contact = $form->getData();
                $entityManager->persist($contact);
                $entityManager->flush();

                $nom = $contact->getNom();
                $prenom = $contact->getPrenom();
                $portable = $contact->getPortable();
                $mail = $contact->getMail();
                $societe = $contact->getSociete();

                $client = new Client();
                $client->setNom($nom);
                $client->setPrenom($prenom);
                $client->setPortable($portable);
                $client->setMail($mail);
                $client->setSociete($societe);
              
                $recupMail = $clientRepository->findOneByMail($mail) ;
                if (!$recupMail) {
                    $entityManager->persist($client);
                    $entityManager->flush();
                }
                $message = (new \Swift_Message('[Ease & Car] Message de confirmation'))
                ->setFrom('mintiontt1@gmail.com')
                ->setTo($contact->getMail())
                ->setBody(
                    
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'send/mail.html.twig', [
                            'controller_name' => 'Message envoyé - Ease & car',
                            'form' => $form->createView(),
                            'var'=>'contact',]),'text/html'); 
                            $mailer->send($message);
                
                            /* envoie de notification à l'admin */
                $message = (new \Swift_Message("[Ease & Car] Message de d'alerte"))
                ->setFrom($contact->getMail())
                ->setTo($notif)
                ->setBody(
                    
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'send/mailAdmin.html.twig', [
                            'controller_name' => 'Message envoyé - Ease & car',
                            'form' => $form->createView(),
                            'var'=>'contact',]),'text/html'); 
                            $mailer->send($message);
                
    
    
                 // return $this->redirectToRoute('contact');
                 return $this->render('send/index.html.twig', [
                    'controller_name' => 'Message envoyé - Ease & car',
                    'var'=>'contact',
                    'form' => $form->createView(),
                ]);
            }
    
            return $this->render('contact/index.html.twig', 
            ['form' => $form->createView(),
            'controller_name' => 'Contact - Ease & car',
            'var'=>'contact'
            ]);
        }




    /**
     * @Route("/liste", name="contact_liste", methods={"GET", "POST"})
     */
    public function liste(ContactRepository $contactRepository): Response
    {
        $user = $this->getUser()->getRoles();
        $useremail = $this->getUser()->getEmail();
        if($user[0] == "ROLE_USER"  OR $user[0] == "ROLE_COMMU"){
        $contacts = $contactRepository->findBy(['mail' => $useremail]);
        }
        else {
        $contacts = $contactRepository->findAll();
        }

        return $this->render('contact/liste.html.twig', [
            'contacts' => $contacts,
            'controller_name' => 'Liste Contacts - Ease & car',
            'var' => 'contact',

            
        ]);
    }

    /**
     * @Route("/new", name="contact_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="contact_show", methods={"GET"})
     */
    public function show( Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contact_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('contact_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'var' => 'contact',  
        ]);
    }

    /**
     * @Route("/{id}", name="contact_delete", methods={"POST"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_liste', [], Response::HTTP_SEE_OTHER);
    }
}
