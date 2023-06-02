<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingsController extends AbstractController
{
    /**
     * @Route("/bookings", name="app_bookings")
     */
    public function index(): Response
    {
        return $this->render('bookings/index.html.twig', [
            'controller_name' => 'BookingsController',
        ]);
    }
}
