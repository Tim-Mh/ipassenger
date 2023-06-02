<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserProfileController extends AbstractController
{
    /**
     * @Route("/user/profile", name="app_user_profile")
     */
    public function index(SessionInterface $session): Response
    {
        $userData = $session->get('user');
        $address = $session->get('address');
        $city = $session->get('city');
        $state = $session->get('state');
        $country = $session->get('country');
        $postcode = $session->get('postcode');
        return $this->render('user_profile/index.html.twig', [
            'controller_name' => 'UserProfileController',
            'userData' => $userData,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'postcode' => $postcode
        ]);
    }

    /**
     * @Route("edit/user/profile", name="edit_user_profile")
     */
    public function edit(SessionInterface $session): Response
    {
        $userData = $session->get('user');
        return $this->render('user_profile/edit.html.twig', [
            'controller_name' => 'UserProfileController',
            'userData' => $userData
        ]);
    }
}
