<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Historique;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use App\Form\AnnoncesType;
use App\Entity\Annonces;
use App\Entity\Images;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index(CategoriesRepository $categoriesRepository)
    {
		$cats = $categoriesRepository->findBy([], ['nom' => 'ASC']);
		
        return $this->render('membre/membre.html.twig', [
            'controller_name' => 'MembreController',
			'cats' => $cats
        ]);
    }
	
	/**
     * @Route("/membre/historique", name="historique")
     */
     
    public function historique(CategoriesRepository $categoriesRepository)
    {
		$cats = $categoriesRepository->findBy([], ['nom' => 'ASC']);
		$his = $this->getUser()->getHistoriques();
		//dd($his);
		
        return $this->render('/membre/historique.html.twig', [
			'cats' => $cats
        ]);
	}
    
    /**
     * @Route("/membre/ajout-annonce", name="ajoutAnnonce")
     */
    public function ajoutAnnonce(?Annonces $annonce, Request $request): Response
    {
        $new = false;
        if (!$annonce) {
            $annonce = new Annonces();
            $new = true;
        }
        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

			//recupère image
				$images = $form->get('images')->getData();


			foreach($images as $image){
				$fichier = md5(uniqid()).'.'. $image->getClientOriginalExtension();

				$image->move(
					$this->getParameter('images_directory'),
					$fichier
				);

				$img = new Images();
				$img->setName($fichier);
				$annonce->addImage($img);
			}

				$em = $this->getDoctrine()->getManager();
				$annonce->setUser($this->getUser());
				$em->persist($annonce);
				$em->flush();
				$this->addFlash('success', 'L\'annonce a bien été ajoutée');
			//	return $this->redirectToRoute('modifierAnnonce');
				return $this->redirect($request->getPathInfo());
		}

        return $this->render('/membre/ajoutAnnonce.html.twig', [
            'annoncesForm' => $form->createView(),
            'annonce' => $annonce,
            'new' => $new
        ]);
    
    }
    
	
	/**
    * @Route("/membre/modifier-annonce-{id}", name="annonceModifier")
    */
    public function modifierAnnonce(?Annonces $annonce, $id, Request $request): Response {

        $new = false;
        if (!$annonce) {
            $annonce = new Annonces();
            $new = true;
        }

     //   $annonce = $this->getDoctrine()->getRepository(Annonce::class)->find($id);

        $form = $this->createForm(AnnoncesType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			//recupère image
				$images = $form->get('images')->getData();


			foreach($images as $image){
				$fichier = md5(uniqid()).'.'. $image->getClientOriginalExtension();

				$image->move(
					$this->getParameter('images_directory'),
					$fichier
				);

				$img = new Images();
				$img->setName($fichier);
				$annonce->addImage($img);
			}

			$em = $this->getDoctrine()->getManager();
				$annonce->setUser($this->getUser());
				$em->persist($annonce);
				$em->flush();
				$this->addFlash('success', 'L\'annonce a bien été modifiée');
			//	return $this->redirectToRoute('modifierAnnonce');
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
	
	/**
     * @Route("/membre/image-supprimer-{id}", name="imageSupprimer")
     */

    public function deleteImage(Request $request, Images $image)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($image);
        $em->flush();
		
		$referer = filter_var($request->headers->get('referer'), FILTER_SANITIZE_URL);

		return $this->redirect($referer);
     }
}
