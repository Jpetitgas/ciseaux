<?php

namespace App\Controller;

// Include Dompdf required namespaces

use App\Repository\ClientRepository;
use App\Repository\DetailFactureRepository;
use App\Repository\FactureRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    /**
     * @Route("/admin/facture/pdf/{id_facture}", name="facture_pdf")
     */
    public function facturePdf($id_facture, ClientRepository $clientRepository, FactureRepository $factureRepository, DetailFactureRepository $detailFactureRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $facture = $factureRepository->find($id_facture);
        $client = $clientRepository->find($facture->getClient());
        $details = $detailFactureRepository->findBy(['facture' => $id_facture]);
        $totals=$detailFactureRepository->totalByPrestationByfacture($facture);
        

        $html = $this->renderView('pdf/facture.html.twig', [
            'facture' => $facture,
            'client' => $client,
            'details' => $details,
            'totals'=>$totals
        ]);
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream('Facture', ['Attachment' => 0]);
        exit(0);

        return new Response();
    }
}
