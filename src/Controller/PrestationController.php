<?php

namespace App\Controller;

use App\Entity\Prestation;
use App\Form\PrestationType;
use App\Repository\PrestationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrestationController extends AbstractController
{
     /**
     * @Route("/prestation", name="prestation")
     */
    public function index(PrestationRepository $prestationRepository, Request $request,EntityManagerInterface $em): Response
    {
       $prestations = $prestationRepository->findAll();
        
        $newprestation = new Prestation;
        $form = $this->createForm(PrestationType::class, $newprestation);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($newprestation);
            $em->flush();
            return $this->RedirectToRoute('prestation');
        }

        $formView = $form->createView();
        return $this->render('prestation/index.html.twig', [
            'prestations' => $prestations,
            'formView' => $formView,
        ]);
    }
     /**
     * @Route("/admin/prestation/delete/{id}", name="prestation_delete")
     */
    public function delete($id, PrestationRepository $prestationRepository, EntityManagerInterface $em): Response
    {
        $prestation = $prestationRepository->find($id);
        $em->remove($prestation);
        $em->flush();
        return $this->RedirectToRoute('prestation');
    }
    /**
     * @Route("/admin/prestation/edit/{id}", name="prestation_edit")
     */
    public function edit($id, PrestationRepository $prestationRepository, Request $request, EntityManagerInterface $em): Response
    {
        $prestations=$prestationRepository->findAll();
        $prestation=$prestationRepository->find($id);
        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->RedirectToRoute('prestation');
        }
        
        $fromView = $form->createView();
        
        return $this->render('prestation/index.html.twig', [
            'prestations' => $prestations,
            'formView' => $fromView,
            'prestation'=>$prestation
        ]);
        
    }
}

