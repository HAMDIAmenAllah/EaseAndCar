<?php

namespace App\Controller;

use App\Form\ChangeMailType;
use App\Form\ChangeNameType;
use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/compte")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'notification'=> null,
            'success' => null,
            'var' => 'Profil',
        ]);
    }

    /**
     * @Route("/modifier-adresse-email", name="accountMail")
     */
    public function mail(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangeMailType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->flush();
            $notification = "Votre adresse email a bien été mis à jour.";
            $success = 'success';
            return $this->render('account/index.html.twig', [
                'notification'=> $notification,
                'success' => $success,
                'var' => 'Profil',
            ]);
        
        }
        return $this->render('account/mail.html.twig', [
            'controller_name' => 'AccountMailController',
            'form' => $form->createView(),
            'var' => 'Profil',

        ]);
    }
    /**
     * @Route("/modifier-nom", name="accountName")
     */
    public function name(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangeNameType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->flush();
            $notification = "Votre nom et prénom ont bien été mis à jour.";
            $success = 'success';
            return $this->render('account/index.html.twig', [
                'notification'=> $notification,
                'success' => $success,
                'var' => 'Profil',
            ]);
        
        }
        return $this->render('account/name.html.twig', [
            'controller_name' => 'AccountNameController',
            'form' => $form->createView(),
            'var' => 'Profil',
        ]);
    }

    /**
     * @Route("/modifier-mot-de-passe", name="accountPassword")
     */
    public function motDePasse(Request $request, UserPasswordHasherInterface $hasher ): Response
    {
        $notification = null;
        $success = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $old_pwd = $form->get('old_password')->getData();
            if ($hasher->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_pwd);

                $user->setPassword($password);

                $doctrine = $this->getDoctrine()->getManager();
                $doctrine->flush();
                $notification = "Votre mot de passe a bien été mis à jour.";
                $success = 'success';
                return $this->render('account/index.html.twig', [
                    'notification'=> $notification,
                    'success' => $success,
                    'var' => 'Profil',
                ]);
            }
            else {
                $notification = "votre mot de passe actuel n'est pas le bon.";
                $success = "s";
                return $this->render('account/index.html.twig', [
                    'notification'=> $notification,
                    'success' => $success,
                    'var' => 'Profil',
                ]);
            }
        }
        return $this->render('account/password.html.twig', [
         'form' => $form->createView(),
         'notification'=> $notification,
         'success' => $success,
         'var' => 'Profil',
        ]);
    }
}
