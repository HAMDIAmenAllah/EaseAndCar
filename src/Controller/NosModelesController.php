<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NosModelesController extends AbstractController
{
    /**
     * @Route("/citadine", name="citadine")
     */
    public function citadine(): Response
    {
        return $this->render('nos_modeles/citadine.html.twig', [
            'controller_name' => 'Citadine - Ease & Car',
            'var' => 'citadine',
        ]);
    }
    
    /**
     * @Route("/nosmodeles", name="nos_modeles")
     */
    public function index(): Response
    {
        return $this->render('nos_modeles/index.html.twig', [
            'controller_name' => 'Nos Modèles - Ease & Car',
            'var' => 'citadine',
        ]);
    }
    
    /**
     * @Route("/handicap", name="handicap")
     */
    public function handicap(): Response
    {
        return $this->render('nos_modeles/pmr.html.twig', [
            'controller_name' => 'Handicap - Ease & Car',
            'var' => 'citadine',
        ]);
    }
    
    /**
     * @Route("/minibus", name="minibus")
     */
    public function minibus(): Response
    {
        return $this->render('nos_modeles/minibus.html.twig', [
            'controller_name' => 'Minibus - Ease & Car',
            'var' => 'citadine',
        ]);
    }
}
