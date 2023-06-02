<?php

namespace App\Controller;

//use App\Entity\User;
//use App\Security\LoginFormAuthenticator;
//use AppleSignIn\ASDecoder;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class AppleController extends AbstractController
{
    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/apple/check", name="connect_apple_check")
     * @param Request $request
     * @param ClientRegistry $clientRegistry
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {

        return $this->redirectToRoute('rideshare');

    }
}