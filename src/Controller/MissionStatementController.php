<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionStatementController extends AbstractController
{
    /**
     * @Route("/mission/statement", name="app_mission_statement")
     */
    public function index(): Response
    {
        return $this->render('mission_statement/index.html.twig', [
            'controller_name' => 'MissionStatementController',
        ]);
    }
}
