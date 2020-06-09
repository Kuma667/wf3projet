<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Annonces;
use App\Entity\Historique;
use App\Entity\User;
use App\Repository\AnnoncesRepository;
use App\Form\AnnoncesType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @Route("/membre/ajout-annonce", name="ajoutAnnonce")
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
				//dd($file->getClientOriginalExtension());
				$nomDuDoc = 'photo-'.uniqid().'.'.$file->getClientOriginalExtension();
				$file->move($repertoire, $nomDuDoc);
				$annonce->setPhoto($nomDuDoc);
			}
			$em = $this->getDoctrine()->getManager();
			$annonce->setUser($this->getUser());
			$em->persist($annonce);
			$em->flush();
			$this->addFlash('success', 'L\'annonce a bien été ajoutée');
			return $this->redirectToRoute('ajoutAnnonce');
			return $this->redirect($request->getPathInfo());
		}

        return $this->render('base/pages/ajoutAnnonce.html.twig', [
            'annoncesForm' => $form->createView(),
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
     * @Route("/annonce-{id}", name="annonceSingle")
     */
     
    public function annonceSingle(Annonces $annonce)
    {
        return $this->render('base/pages/annonceSingle.html.twig', [
            'annonce' => $annonce,
        ]);
    }


      /**
     * @Route("/annonces-liste", name="annoncesListe")
     */
    public function annonces_list(AnnoncesRepository $annoncesRepository)
    {
        return $this->render('base/pages/annoncesListe.html.twig', [
            'annonces' => $annoncesRepository->findAll(),
        ]);
    }
	
	/**
     * @Route("/annonces", name="annonces")
     */
    public function annonces(AnnoncesRepository $annoncesRepository)
    {
        return $this->render('base/pages/allAnnonces.html.twig', [
            'annonces' => $annoncesRepository->findAll(),
        ]);
    }

     
}
