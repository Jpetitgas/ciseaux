<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Form\FactureType;
use App\Entity\DetailFacture;
use App\Form\DetailFactureType;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DetailFactureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FactureController extends AbstractController
{
    /**
     * @Route("/admin/facture", name="facture")
     */
    public function index(FactureRepository $factureRepository, Request $request,EntityManagerInterface $em)
    {
        $factures = $factureRepository->findAllByDateOrder('DESC');
        
        $newFacture = new Facture;
        $form = $this->createForm(FactureType::class, $newFacture);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($newFacture);
            $em->flush();
            return $this->RedirectToRoute('facture');
        }

        $formView = $form->createView();
        return $this->render('facture/index.html.twig', [
            'factures' => $factures,
            'formView' => $formView,
        ]);
    }
    
    /**
     * @Route("/admin/facture/detail/{id_facture}", name="detail_facture_edit")
     */
    public function edit($id_facture, FactureRepository $factureRepository,DetailFactureRepository $detailFactureRepository, Request $request, EntityManagerInterface $em)
    {
        $details = $detailFactureRepository->findBy(array('facture' => $id_facture));
        
        $newdetail = new DetailFacture;
        
                
        $form = $this->createForm(DetailFactureType::class, $newdetail);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facture= $factureRepository->find($id_facture);
            $newdetail->setFacture($facture);
            $em->persist($newdetail);
            $em->flush();
            return $this->RedirectToRoute('detail_facture_edit',['id_facture'=>$id_facture]);
        }
        
        $formView = $form->createView();

        return $this->render('facture/detailFacture.html.twig', [
            'facture' => $id_facture,
            'details' => $details,
            'formView' => $formView,

        ]);
    }
    /**
     * @Route("/admin/facture/{id_facture}", name="facture_edit")
     */
    public function editFacture($id_facture, FactureRepository $factureRepository,DetailFactureRepository $detailFactureRepository, Request $request, EntityManagerInterface $em)
    {
        $facture = $factureRepository->find($id_facture);
        
               
                
        $form = $this->createForm(FactureType::class, $facture);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($facture);
            $em->flush();
            return $this->RedirectToRoute('facture');
        }
        
        $formView = $form->createView();

        return $this->render('facture/editFacture.html.twig', [
            'facture' => $id_facture,
            
            'formView' => $formView,

        ]);
    }
    
}
