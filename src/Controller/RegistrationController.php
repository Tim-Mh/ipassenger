<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="app_registration")
     */
    public function index(): Response
    {
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController',
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request , FlashBagInterface $flashBag)
    {
        $email = $request->request->get('email');
        $password = $request->request->get('plainPassword');
        $confirmPassword = $request->request->get('cpass');
        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');

        // Make a request to the registration API
        $apiUrl = 'https://elimousines.net/jwt_register';
        $params = [
            'email' => $email,
            'plainPassword' => $password,
            'cpass' => $confirmPassword,
            'firstName' => $firstName,
            'lastName' => $lastName
        ];

        $httpClient = HttpClient::create();
        $response = $httpClient->request('POST', $apiUrl, [
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
            'body' => http_build_query($params)
        ]);

        if ($response->getStatusCode() == Response::HTTP_OK) {
            $data = json_decode($response->getContent(), true);

            if ($data['status'] === false && isset($data['errors']) && in_array('User already Exist with this email!', $data['errors'])) {
                // User already exists with this email
                $this->addFlash('error', 'User already exists with this email!');
                return $this->redirectToRoute('app_registration');
            }

            // Registration successful
            $this->addFlash('success', 'Registration successful!');
            return $this->redirectToRoute('app_login');
        }

        // Other error occurred
        $this->addFlash('error', 'An error occurred during registration.');
        return $this->redirectToRoute('app_registration');
    }
}
