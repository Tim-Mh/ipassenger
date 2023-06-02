<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;


class LoginController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }



    /**
     * @Route("/login", name="app_login")
     */
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }


    /**
     * @Route("/authenticate", name="authenticate", methods={"GET", "POST"} )
     */
    public function authenticate(Request $request, SessionInterface $session)
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        // You can validate the email and password if needed

        // Make a request to the login API
        $apiUrl = 'https://elimousines.net/jwt_login';
        $params = [
            'usr' => $email,
            'pw' => $password
        ];

        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $apiUrl, ['query' => $params]);

        if ($response->getStatusCode() == 200) {
            $data = json_decode($response->getContent(), true);

            if (isset($data['jwt'])) {
                $session->set('user', $data['user']);
                $session->set('address', $data['address']);
                $session->set('city', $data['city']);
                $session->set('state', $data['state']);
                $session->set('country', $data['country']);
                $session->set('postcode', $data['postCode']);

                // Store the token in session or any other storage mechanism
                // $this->session->set('token', $data['jwt']);

                // Redirect to a protected route or perform other actions
                return $this->redirectToRoute('app_user_profile');
            } else {
                $this->addFlash('error', 'Invalid response from API');
            }
        } else {
            $this->addFlash('error', 'Invalid email or password');
            return $this->redirectToRoute('app_login');
        }

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(SessionInterface $session)
    {
        // Clear the stored token from session or any other storage mechanism
        $session->remove('jwt');
        $session->remove('user');
        $session->remove('user_name');
        $session->remove('user_email');
        $session->remove('user_data');
        $session->remove('user_google');

        // Redirect to the login page or perform other actions
        return $this->redirectToRoute('app_login');
    }
}
