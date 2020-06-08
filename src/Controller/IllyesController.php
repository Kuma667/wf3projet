<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IllyesController extends AbstractController
{
    /**
     * @Route("/illyes", name="illyes")
     */
    public function index()
    {
        return $this->render('illyes/index.html.twig', [
            'controller_name' => 'IllyesController',
        ]);
    }
}
