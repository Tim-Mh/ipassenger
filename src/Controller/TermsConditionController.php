<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermsConditionController extends AbstractController
{
    /**
     * @Route("/terms/condition", name="app_terms_condition")
     */
    public function index(): Response
    {
        return $this->render('terms_condition/index.html.twig', [
            'controller_name' => 'TermsConditionController',
        ]);
    }
}
