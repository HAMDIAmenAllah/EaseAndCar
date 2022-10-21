<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->render('admin/index.html.twig', [
                'controller_name' => 'Admin - Ease & Car',
                'var' => '',
                
            ]);
        }
        return $this->render('security/login.html.twig', [
            'controller_name' => 'Admin - Ease & Car',
            'var' => '',
        ]);
        
        /* return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'var' => '',
        ]); */
    }
}
