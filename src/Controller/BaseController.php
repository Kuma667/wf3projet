<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/index", name="accueil")
     */
    public function index()
    {
        return $this->render('base/index.html.twig', [
            
        ]);
    }


    /**
     * @Route("/ajout-annonce", name="ajouAnnonce")
     */
    public function ajouAnnonce(
        
        ?annonce $annonce,
        Request $request
       
    ) {

        $new = false;
        if (!$annonce) {
            $annonce = new Annonce();
            $new = true;
        }

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 

        return $this->render('blog/ajoutAnnonce.html.twig', [
            'form' => $form->createView(),
            'new' => $new,
            'annonce' => $annonce,
        ]);
    }



    public function header($ROUTE_NAME)
    {
        // REQUETE SQL

        return $this->render('_partials/header.html.twig', [
            'ROUTE_NAME' => $ROUTE_NAME,
        ]);
    }


    /**
     * @Route("/annonce-single", name="annonceSingle")
     */
     
    public function annonceSingle(Annonces $annonceSingle)
    {
        return $this->render('pages/annonceSingle.html.twig', [
            'annonces' => $annonces
        ]);
    }


      /**
     * @Route("/annonces-liste", name="annoncesListe")
     */
    public function annonces_list(AnnoncesRepository $AnnoncesRepository)
    {
        return $this->render('base/pages/annoncesListe.html.twig', [
            'annonces' => $AnnoncesRepository->findAll(),
        ]);
    }

     
}
