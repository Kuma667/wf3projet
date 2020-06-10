<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Annonces;
use App\Entity\Historique;
use App\Entity\User;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use App\Form\AnnoncesType;

class SearchController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function search(Request $request, AnnoncesRepository $annoncesRepository, CategoriesRepository $categoriesRepository)
    {
		//dd($request);
        $search = $request->query->get('search');
		$categorie = $request->query->get('categorie');
		$order = $request->query->get('order');
		
		$cats = $categoriesRepository->findBy([], ['nom' => 'ASC']);
		$villes = $annoncesRepository->findBy([], ['ville' => 'ASC']);
		//dd($villes);
		
		$query = $annoncesRepository->createQueryBuilder('a');
		if($search){
			$query->andWhere('a.titre LIKE :titre')
				->setParameter('titre', '%'.$search.'%');
		}
		
		if($order && in_array($order, ['id', 'prix'])){
			$query->orderBy('a.'.$order, 'ASC');
		}else{
			$query->orderBy('a.id', 'DESC');
		}
			
		if($categorie){
			$query->innerJoin('a.categorie', 'categorie')
			->andWhere('categorie.nom = :categorie')
			->setParameter('categorie', $categorie);
		}
			$res = $query
				->getQuery()
				->getResult();
			//dd($res);

		
        return $this->render('base/index.html.twig', [
            'res' => $res,
			'cats' => $cats,
			'villes' => $villes
        ]);
    }
	
	/**
     * @Route("/search", name="searchResult")
     */
	public function searchResult(Request $request, AnnoncesRepository $annoncesRepository, CategoriesRepository $categoriesRepository){
		
		$search = $request->query->get('search');
		$categorie = $request->query->get('categorie');
		$order = $request->query->get('order');
		$villes = $annoncesRepository->findBy([], ['ville' => 'ASC']);
		
		
		$cats = $categoriesRepository->findBy([], ['nom' => 'ASC']);
		
		$query = $annoncesRepository->createQueryBuilder('a');
		if($search){
			$query->andWhere('a.titre LIKE :titre')
				->setParameter('titre', '%'.$search.'%');
		}
		
		if($order && in_array($order, ['id', 'prix'])){
			$query->orderBy('a.'.$order, 'ASC');
		}else{
			$query->orderBy('a.id', 'DESC');
		}
			
		if($categorie){
			$query->innerJoin('a.categorie', 'categorie')
			->andWhere('categorie.nom = :categorie')
			->setParameter('categorie', $categorie);
		}
			$res = $query
				->getQuery()
				->getResult();
			//dd($res);
		return $this->render('base/pages/searchAnnonce.html.twig',[
			'res' => $res,
			'cats' => $cats,
			'villes' => $villes
		]);
	}
}
