<?php

namespace App\Controller;


use App\Form\DetailFactureType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DetailFactureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DetailFactureController extends AbstractController
{

    /**
     * @Route("/admin/detailfacture/edit/{id}", name="detail_edit")
     */
    public function edit($id, DetailFactureRepository $detailFactureRepository, Request $request, EntityManagerInterface $em)
    {
        $detail = $detailFactureRepository->find($id);
        
        $details = $detailFactureRepository->findBy(array('facture' => $detail->getFacture()->getId()));
        
        $form = $this->createForm(DetailFactureType::class, $detail);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($detail);
            $em->flush();
            return $this->RedirectToRoute('detail_facture_edit', ['id_facture' => $detail->getFacture()->getId()]);
        }

        $formView = $form->createView();
        
        return $this->render('facture/detailFacture.html.twig', [
            'facture'=>$detail->getFacture()->getId(),
            'details' => $details,
            'formView' => $formView,

        ]);
    }
    /**
     * @Route("/admin/detailfacture/delete/{id}", name="detail_delete")
     */
    public function delete($id, DetailFactureRepository $detailFactureRepository, EntityManagerInterface $em)
    {
        $detail = $detailFactureRepository->find($id);

        $em->remove($detail);
        $em->flush();
        return $this->RedirectToRoute('detail_facture_edit', ['id_facture' => $detail->getFacture()->getId()]);
    }
}
