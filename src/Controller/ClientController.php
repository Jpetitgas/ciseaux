<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    /**
     * @Route("/admin/client", name="client")
     */
    public function index(ClientRepository $clientRepository, Request $request, EntityManagerInterface $em): Response
    {
        $clients=$clientRepository->findAll();
        $newclient = new Client;
        $form = $this->createForm(ClientType::class, $newclient);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newclient);
            $em->flush();
            return $this->RedirectToRoute('client');
        }
        
        $fromView = $form->createView();
        
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'formView' => $fromView
        ]);
        
    }
    /**
     * @Route("/admin/client/delete/{id}", name="client_delete")
     */
    public function delete($id, ClientRepository $clientRepository, EntityManagerInterface $em): Response
    {
        $client = $clientRepository->find($id);
        $em->remove($client);
        $em->flush();
        return $this->RedirectToRoute('client');
    }
    /**
     * @Route("/admin/client/edit/{id}", name="client_edit")
     */
    public function edit($id, ClientRepository $clientRepository, Request $request, EntityManagerInterface $em): Response
    {
        $clients=$clientRepository->findAll();
        $client=$clientRepository->find($id);
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->RedirectToRoute('client');
        }
        
        $fromView = $form->createView();
        
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'formView' => $fromView,
            'client'=>$client
        ]);
        
    }
}
