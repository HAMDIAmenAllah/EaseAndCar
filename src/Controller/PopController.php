<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class PopController extends AbstractController
{
    /**
     * @Route("/pop", name="pop")
     */
    public function index(Session $session ): Response
    {
 
        $pop = $session->set('pop', 1);
       
    
        //dd($pop);
     
        return $this->redirectToRoute('home', []);
    }

}

