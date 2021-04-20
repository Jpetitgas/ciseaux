<?php

namespace App\Controller;

use App\Graph\GraphDataPrestation;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\DetailFactureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TableauDeBordController extends AbstractController
{
    /**
     * @Route("/admin", name="index_admin")
     */
    public function index(GraphDataPrestation $graphDataPrestation, ChartBuilderInterface $chartBuilder): Response
    {
        $data=$graphDataPrestation->prestation();
       
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $data['month'],
            'datasets' => [
                    [
                    'label' => 'Prestation',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data['dataPds'],
                    ],
                    [
                    'label' => 'Vente',
                    'backgroundColor' => 'rgb(0,191,255)',
                    'borderColor' => 'rgb(0,191,255)',
                    'data' => $data['dataVente'],
                    ],
            ],
        ]);

        

        return $this->render('tableau_de_bord/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
