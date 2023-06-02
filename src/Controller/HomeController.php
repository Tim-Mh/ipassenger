<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/taxis", name="taxis")
     */
    public function taxis()
    {
        return $this->render('home/taxis.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/limousines", name="limousines")
     */
    public function limousines(): Response
    {
        return $this->render('home/limousines.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/rideshare", name="rideshare")
     */
    public function rideshare(): Response
    {
        return $this->render('home/rideshare.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/intercity", name="intercity")
     */
    public function intercity(): Response
    {
        return $this->render('home/intercity.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/transit", name="transit")
     */
    public function transit(): Response
    {
        return $this->render('home/transit.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
