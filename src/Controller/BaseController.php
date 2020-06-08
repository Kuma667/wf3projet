<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Annonces;
use App\Entity\Historique;
use App\Entity\User;
use App\Form\AnnoncesType;

class BaseController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        return $this->render('base/index.html.twig', [
            
        ]);
    }


    /**
     * @Route("/ajout-annonce", name="ajoutAnnonce")
     */
    public function ajoutAnnonce(?Annonces $annonce, Request $request){

        $new = false;
        if (!$annonce) {
            $annonce = new Annonces();
            $new = true;
        }

        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			$file = $form['photo']->getData();
			if($file){
				$repertoire = $this->getParameter('uploadPhotos');
				$nomDuDoc = 'photo-'.uniqid().'.'.$file->guessExtension();
				$file->move($repertoire, $nomDuDoc);
				$annonce->setPhoto($nomDuDoc);
			}
		}

        return $this->render('base/pages/ajoutAnnonce.html.twig', [
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
	
	public function footer($ROUTE_NAME)
    {
        // REQUETE SQL

        return $this->render('_partials/footer.html.twig', [
            'ROUTE_NAME' => $ROUTE_NAME,
        ]);
    }


    /**
     * @Route("/annonce-single-{id}", name="annonceSingle")
     */
     
    public function annonceSingle(Annonces $annonceSingle)
    {
        return $this->render('base/pages/annonceSingle.html.twig', [
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
	
	 /**
     * @Route("/historique", name="historique")
     */
     
    public function historique()
    {
        return $this->render('base/pages/historique.html.twig', [
        ]);
    }

     
}
