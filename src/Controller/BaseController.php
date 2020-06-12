<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Annonces;
use App\Repository\ImagesRepository;
use App\Entity\Historique;
use App\Entity\User;
use App\Entity\Images;
use App\Service\EmailService;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use App\Form\AnnoncesType;
use Symfony\Component\HttpFoundation\Response;
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
     
    public function annonceSingle(Annonces $annonce, CategoriesRepository $categoriesRepository)
    {
		$cats = $categoriesRepository->findBy([], ['nom' => 'ASC']);
		
        return $this->render('base/pages/annonceSingle.html.twig', [
            'annonce' => $annonce,
			'cats' => $cats
        ]);
    }


      /**
     * @Route("/annonces-liste", name="annoncesListe")
     */
    public function annonces_list(AnnoncesRepository $annoncesRepository, CategoriesRepository $categoriesRepository){
		$cats = $categoriesRepository->findBy([], ['nom' => 'ASC']);
		
        return $this->render('base/pages/annoncesListe.html.twig', [
            'annonces' => $annoncesRepository->findAll(),
			'cats' => $cats
        ]);
    }
	
	/**
     * @Route("/annonces", name="annonces")
     */
    public function annonces(AnnoncesRepository $annoncesRepository, CategoriesRepository $categoriesRepository)
    {
		$cats = $categoriesRepository->findBy([], ['nom' => 'ASC']);
        return $this->render('base/pages/allAnnonces.html.twig', [
            'annonces' => $annoncesRepository->findAll(),
			'cats' => $cats
        ]);
    }
	
	/**
     * @Route("/contact-pro", name="contactPro")
     */
	public function contactPro(Request $request, EmailService $emailService){
		
		if($request->isMethod('POST')){
			$nom = $request->request->get('nom');
			$prenom = $request->request->get('prenom');
			$sujet = $request->request->get('sujet');
			$mail = $request->request->get('email');
			$msg = $request->request->get('message');
			$userMail = $request->request->get('userMail');
			
			// Envoi de l'email
			$send = $emailService->sendMailPro($nom, $prenom, $sujet, $mail, $msg, $userMail);
			$this->addFlash('success', 'Votre message a bien été envoyé.');
			$referer = filter_var($request->headers->get('referer'), FILTER_SANITIZE_URL);
			//return $this->redirectToRoute('contactPro');
		}
		
		return $this->redirect($referer);
	}


    



    


     
}