<?php

namespace App\Controller;


use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\GraphNodes\GraphUser;
use Facebook\Facebook;

use Symfony\Component\HttpFoundation\RedirectResponse;



class FacebookController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/facebook", name="connect_facebook_start")
     * @param ClientRegistry $clientRegistry
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry, Request $request): RedirectResponse
    {
        // on Symfony 3.3 or lower, $clientRegistry = $this->get('knpu.oauth2.registry');

        // will redirect to Facebook!

        $state = $request->get('state', 'user');
        return $clientRegistry
            ->getClient('facebook_main') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect([
                'public_profile', 'email' // the scopes you want to access
            ], ['state' => $state]);
    }


    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/facebook/check", name="connect_facebook_check")
     * @param Request $request
     * @param ClientRegistry $clientRegistry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry, SessionInterface $session)
    {

        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var \KnpU\OAuth2ClientBundle\Client\Provider\FacebookClient $client */        //dd($request->query->get('state'));die;
        $client = $clientRegistry->getClient('facebook_main');

        try {
            // the exact class depends on which provider you're using
            /** @var \League\OAuth2\Client\Provider\FacebookUser $user */
            $user = $client->fetchUser();
            $session->set('user_data', $user->toArray());

            // Access the data as needed
            $userData = $session->get('user_data');





        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage());
            die;
        }
        return $this->redirectToRoute('rideshare');
    }

}
