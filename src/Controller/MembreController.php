<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index()
    {
        return $this->render('membre/membre.html.twig', [
            'controller_name' => 'MembreController',
        ]);
    }
	
	/**
     * @Route("/membre/historique", name="historique")
     */
     
    public function historique()
    {
        return $this->render('base/membre/historique.html.twig', [
			
        ]);

    #$iduser = $this->getUser()->getId();
    public function membresAnnoncesList(AnnoncesRepository $annoncesRepo)
    {
        if($iduser = $this->getUser()->getId())
        {
            $liste = $annoncesRepo->findAll(); 
        }
    }
}
