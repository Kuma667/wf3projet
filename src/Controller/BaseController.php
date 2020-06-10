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


    



    


     
}