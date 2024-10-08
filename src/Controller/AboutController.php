<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/apropos", name="about")
     */
    public function index(): Response
    {
        return $this->render('about/index.html.twig', [
            'controller_name' => 'À Propos - Ease & Car',
            'var' => 'about',
        ]);
    }
}
