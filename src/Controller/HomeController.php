<?php

namespace App\Controller;

use App\Repository\BandeauRepository;
use App\Repository\CommentcamarcheRepository;
use App\Repository\SectioncarouselRepository;
use App\Repository\SectiondeviRepository;
use App\Repository\SectionnosengagementsRepository;
use App\Repository\SectionnosservicesRepository;
use App\Repository\SectiontemoignageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SectioncarouselRepository $sectioncarouselRepository, SectionnosservicesRepository $sectionnosservicesRepository, CommentcamarcheRepository $commentcamarcheRepository,SectiondeviRepository $sectiondeviRepository,SectionnosengagementsRepository $sectionnosengagementsRepository,BandeauRepository $bandeauRepository,SectiontemoignageRepository $sectiontemoignageRepository, Session $session): Response
    {
        /* $cookkie = new Cookie ('couleur', //Nom cookie
        'Rouge', //Valeur
         strtotime('tomorrow'), //expire le
         '/', //Chemin de serveur
        'stacktraceback.com', //Nom domaine
        true, //Https seulement
        true); // Disponible uniquement dans le protocole HTTP */

        $session = new Session();
        $session->start();
        $session->get('pop');
        if ($session->get('pop') !=1 ) {
            $pop = 0;

          
        }
        else {
            $pop = 1 ; 
        }
        /* dd($session->get('pop')); */
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Accueil - Ease & car',
            'var'=>'home',
            'sectioncarousels' => $sectioncarouselRepository->findAll(),
            'sectionnosservices' => $sectionnosservicesRepository->findAll(),
            'commentcamarches' => $commentcamarcheRepository->findAll(),
            'sectiondevis' => $sectiondeviRepository->findAll(),
            'sectionnosengagements' => $sectionnosengagementsRepository->findAll(),
            'bandeaus' => $bandeauRepository->findAll(),
            'sectiontemoignages' => $sectiontemoignageRepository->findAll(),
            'pop' => $pop,

        ]);
    }
}
