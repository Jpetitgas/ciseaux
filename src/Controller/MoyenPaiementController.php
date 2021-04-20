<?php

namespace App\Controller;

use App\Entity\MoyenPaiement;
use App\Form\MoyenPaiementType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MoyenPaiementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoyenPaiementController extends AbstractController
{
    /**
     * @Route("/moyenpaiement", name="moyen_paiement")
     */
    public function index(MoyenPaiementRepository $moyenPaiementRepository, Request $request,EntityManagerInterface $em): Response
    {
       $MoyenPaiements = $moyenPaiementRepository->findAll();
        
        $newMoyenPaiement = new MoyenPaiement;
        $form = $this->createForm(MoyenPaiementType::class, $newMoyenPaiement);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($newMoyenPaiement);
            $em->flush();
            return $this->RedirectToRoute('moyen_paiement');
        }

        $formView = $form->createView();
        return $this->render('moyen_paiement/index.html.twig', [
            'moyenpaiements' => $MoyenPaiements,
            'formView' => $formView,
        ]);
    }
     /**
     * @Route("/admin/moyenpaiement/delete/{id}", name="moyen_paiement_delete")
     */
    public function delete($id, MoyenPaiementRepository $moyenPaiementRepository, EntityManagerInterface $em): Response
    {
        $MoyenPaiement = $moyenPaiementRepository->find($id);
        $em->remove($MoyenPaiement);
        $em->flush();
        return $this->RedirectToRoute('moyen_paiement');
    }
    /**
     * @Route("/admin/moyenpaiement/edit/{id}", name="moyen_paiement_edit")
     */
    public function edit($id, MoyenPaiementRepository $moyenPaiementRepository, Request $request, EntityManagerInterface $em): Response
    {
        $MoyenPaiements=$moyenPaiementRepository->findAll();
        $MoyenPaiement=$moyenPaiementRepository->find($id);
        $form = $this->createForm(MoyenPaiementType::class, $MoyenPaiement);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->RedirectToRoute('moyen_paiement');
        }
        
        $fromView = $form->createView();
        
        return $this->render('moyen_paiement/index.html.twig', [
            'moyenpaiements' => $MoyenPaiements,
            'formView' => $fromView,
            'moyenpaiement'=>$MoyenPaiement
        ]);
        
    }
}
