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
        return $this->render('membre/index.html.twig', [
            'controller_name' => 'MembreController',
        ]);
    }

    #$iduser = $this->getUser()->getId();
    public function membresAnnoncesList(AnnoncesRepository $annoncesRepo)
    {
        if($iduser = $this->getUser()->getId())
        {
            $liste = $annoncesRepo->findAll(); 
        }
    }
}
