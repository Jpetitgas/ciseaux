<?php

namespace App\Graph;

use App\Repository\DetailFactureRepository;
use Symfony\Component\Intl\DateFormatter\DateFormat\MonthTransformer;

class GraphDataPrestation
{
    public $factureRepository;

    public function __construct(DetailFactureRepository $detailFactureRepository)
    {
        $this->factureRepository = $detailFactureRepository;
    }

    public function prestation()
    {
        $data=[];
        $months = $this->factureRepository->month();
        $monthArray=[];
        $cp=0;
        foreach ($months as $month){
            $monthArray[$cp]=$month['date'];
            ++$cp;
        }
        $data['month']= $monthArray;
        $prestations=$this->factureRepository->totalByPrestationByMois();
        
        foreach ($prestations as $prestation){
            if ($prestation['typeDePrestation']=='Vente'){
                $dataVente[]=$prestation['total'];
            } else {
                $dataPds[]=$prestation['total'];
            }
                     
        }
        $data['dataPds']=$dataPds;
        $data['dataVente']=$dataVente;
        return $data;
    }
}
