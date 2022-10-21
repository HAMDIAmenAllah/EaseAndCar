<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Entity\Devis;
use App\Entity\Facture;
use App\Repository\DetailsDevisRepository;
use App\Repository\DetailsFactureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class GenerPdfController extends AbstractController
{
    /**
     * @Route("/{id}/devis-pdf", name="devis_pdf")
     */
    public function devisPdf(Devis $devis, DetailsDevisRepository $detailsDevisRepository)
    {
        $data = $detailsDevisRepository->findBy(['Devis' => $devis]);
        $tht = 0;
        for ($i=0; $i < sizeof($data); $i++) { 
            $tht += $data[$i]->getTarifHT();
        }
        $tva = $tht * $devis->getTVA() / 100;
        $ttc = $tht + $tva;
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('gener_pdf/devis.html.twig', [
            'title' => "Welcome to our PDF Test",
            'devisCar' => $devis,
            'tht' => $tht,
            'TVA' => $tva,
            'TTC' => $ttc,
        ]);
        $dompdf->loadHtml($html); 
        $dompdf->setPaper('A4', 'portrait'); 
        $dompdf->render(); 
        $dompdf->stream("Devis.pdf", [
            "Attachment" => true,

        ]);
      
        return new Response('success', 200, [
            'Content-Type' => 'application/pdf',
            'tht' => $tht,
            'TVA' => $tva,
            'TTC' => $ttc,
          ]);


    }


      /**
     * @Route("/{id}/showdevis-pdf", name="showdevis_pdf")
     */
    public function showdevisPdf(Devis $devis, DetailsDevisRepository $detailsDevisRepository)
    {
        $data = $detailsDevisRepository->findBy(['Devis' => $devis]);
        $tht = 0;
        for ($i=0; $i < sizeof($data); $i++) { 
            $tht += $data[$i]->getTarifHT();
        }
        $tva = $tht * $devis->getTVA() / 100;
        $ttc = $tht + $tva;
 
       
        // Retrieve the HTML generated in our twig file
        return $this->render('gener_pdf/devis.html.twig', [
            'title' => "Welcome to our PDF Test",
            'devisCar' => $devis,
            'tht' => $tht,
            'TVA' => $tva,
            'TTC' => $ttc,
         
        ]);
 
        


    }

    /**
     * @Route("/{id}/facture-pdf", name="facture_pdf")
     */
    public function FacturePdf(Facture $facture, DetailsFactureRepository $detailsFactureRepository)
    {
        $data = $detailsFactureRepository->findBy(['facture' => $facture]);
        $prixHt = 0;
        for ($i=0; $i < sizeof($data); $i++) { 
            $prixHt += $data[$i]->getTarifHT();
        }

        $tva = $prixHt * $facture->getTVA() / 100;
        $prixTtc = $prixHt + $tva;
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
       
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('gener_pdf/facture.html.twig', [
            'title' => "Welcome to our PDF Test",
            'facture' => $facture,
            'prixHt' => $prixHt,
            'TVA' => $tva,
            'prixTtc' => $prixTtc,
            /* '<img width="220" height="220" src="test.jpg">', */
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        /* $html .= '<style>
        '.file_get_contents("../../public/assets/css/bootstrap.css").'
        </style>'; */

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Facture.pdf", [
            "Attachment" => true,

        ]);
        
        /* return new Response("The PDF file has been succesfully generated !"); */
        return new Response('success', 200, [
            'Content-Type' => 'application/pdf',
            'facture' => $facture,
            'prixHt' => $prixHt,
            'TVA' => $tva,
            'prixTtc' => $prixTtc,
          ]);
    }

    /**
     * @Route("/{id}/contrat-pdf", name="contrat_pdf")
     */
    public function contratPdf(Contrat $contrat)
    {
        
        $tht = $contrat->getTarifHT();
        $tva = $tht * $contrat->getTVA() / 100;
        $ttc = $tht + $tva;
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('gener_pdf/contrat.html.twig', [
            'title' => "Welcome to our PDF Test",
            'contrat' => $contrat,
            'tht' => $tht,
            'TVA' => $tva,
            'TTC' => $ttc,
            'var' => '',
            'form' =>'',  
        ]);

       /*  return $this->render('gener_pdf/contrat.html.twig', [
            'title' => "Welcome to our PDF Test",
            'contrat' => $contrat,
            'tht' => $tht,
            'TVA' => $tva,
            'TTC' => $ttc,
            'var' => '',]);
            'form' =>'',  
        ]); */
        $dompdf->loadHtml($html); 
        $dompdf->setPaper('A4', 'portrait'); 
        $dompdf->render(); 
        $dompdf->stream("Devis.pdf", [
            "Attachment" => true,

        ]); 
        return new Response('success', 200, [
            'Content-Type' => 'application/pdf',
            'tht' => $tht,
            'TVA' => $tva,
            'TTC' => $ttc,
           
          ]);

    }

}
