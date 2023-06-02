<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

use Symfony\Component\HttpFoundation\Request;




class GoogleController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/google", name="connect_google_start")
     * @param ClientRegistry $clientRegistry
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry, Request $request)
    {
        // on Symfony 3.3 or lower, $clientRegistry = $this->get('knpu.oauth2.registry');

        // will redirect to Google!
        $state = $request->get('state', 'user');
        return $clientRegistry
            ->getClient('google') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect([
                'email' // the scopes you want to access
            ], ['state' => $state]);
    }

    /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/google/check", name="connect_google_check")
     * @param Request $request
     * @param ClientRegistry $clientRegistry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry, SessionInterface $session)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /** @var \KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient $client */
        $client = $clientRegistry->getClient('google');

//        dump($client, $request);

        try {
            // the exact class depends on which provider you're using
            /** @var \League\OAuth2\Client\Provider\GoogleUser $user */
            $user = $client->fetchUser();
            $session->set('user_google', $user->toArray());
            $userData = $session->get('user_google');
//
            // Access the user's email and name
            $email = $user->getEmail();
            $name = $user->getName();

            // Store the user details in the session
            $session->set('user_email', $email);
            $session->set('user_name', $name);

            // Redirect to the desired route (rideshare in this case)
            return $this->redirectToRoute('rideshare');

        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage());
            die;
        }
        return $this->redirectToRoute('rideshare');
    }
}
