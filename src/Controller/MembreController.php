<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Annonces;
use App\Entity\Historique;
use App\Repository\AnnoncesRepository;
use App\Form\AnnoncesType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


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
        return $this->render('/membre/historique.html.twig', [
			
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

        return $this->render('membre/ajoutAnnonce.html.twig', [
            'annoncesForm' => $form->createView(),
            'new' => $new,
            'annonce' => $annonce,
        ]);
    }
	
	    /**
     * @Route("/membre/modifier-annonce-{id}", name="annonceModifier")
     */
    public function modifierAnnonce(?Annonces $annonce, $id, Request $request){

        $new = false;
        if (!$annonce) {
            $annonce = new Annonces();
            $new = true;
        }

     //   $annonce = $this->getDoctrine()->getRepository(Annonce::class)->find($id);

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
			$em->flush();
			$this->addFlash('success', 'L\'annonce a bien été modifié');
			
			return $this->redirect($request->getPathInfo());
		}

        return $this->render('/membre/modifierAnnonce.html.twig', [
            'annoncesForm' => $form->createView(),
            'new' => $new,
            'annonce' => $annonce,
        ]);
    }
	
	/**
     * @Route("/membre/annonce-supprimer-{id}", name="annonceSupprimer")
     */
    public function annonceSupprimer(AnnoncesRepository $annoncesRepository, $id) {
		$em = $this->getDoctrine()->getManager();
        $annonce = $annoncesRepository->find($id);
        if ($annonce) {
            $em->remove($annonce);
            $em->flush();
        }
        return $this->redirectToRoute('membre');
        return $this->render('/membre/annonceSupprimer.html.twig', [
        ]);
    }
}
