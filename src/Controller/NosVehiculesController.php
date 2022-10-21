<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NosVehiculesController extends AbstractController
{
    /**
     * @Route("/nosvehicules", name="nos_vehicules")
     */
    public function index(): Response
    {
        return $this->render('nos_vehicules/index.html.twig', [
            'controller_name' => 'Nos Vehicules - Ease & car',
            'var'=>'nos_vehicules',

        ]);
    }
}
