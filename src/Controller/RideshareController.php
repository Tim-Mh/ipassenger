<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpClient\HttpClient;

class RideshareController extends AbstractController
{
    /**
     * @Route("/rideshare/search", name="rideshare_search")
     */
    public function index(Request $request, SessionInterface $session): Response
    {
        $fromCityLat = $request->request->get('from_city_Lat');
        $fromCityLng = $request->request->get('from_city_Lng');
        $toCityLat = $request->request->get('to_city_Lat');
        $toCityLng = $request->request->get('to_city_Lng');
        $vehicleCategory = $request->request->get('vehicleCategory');
        $fromCity = $request->request->get('fromCity');
        $toCity = $request->request->get('toCity');

        $adaAssistance = $request->request->get('adaAssistance');
        $fromDateTime = $request->request->get('from');


        $dateString = $fromDateTime;
        $date = DateTime::createFromFormat('Y-m-d H:i', $dateString);
        if ($date !== false) {
            $fromDate = $date->format('m/d/Y h:i A');
        } else {
            // Handle the case where $date is not a valid DateTime object
            $fromDate = 'Invalid date';
        }



        if ($date !== false) {
            $toDate = $date->format('m/d/Y h:i A');
        } else {
            return $this->redirectToRoute('app_home');
        }

        $baseUrl = 'https://erideshare.net/search-result';
        $queryParams = [
            'fromCity' => $fromCity,
            'toCity' =>  $toCity,
            'from_city_Lat' => $fromCityLat,
            'from_city_Lng' =>  $fromCityLng,
            'to_city_Lat' => $toCityLat,
            'to_city_Lng' =>  $toCityLng,
            'from' => $fromDate,

            'vehicleCategory' => $vehicleCategory,
            'ada' => $adaAssistance,
            'jwt' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTEsImV4cCI6NTI2MDI4NjQ3M30.3yuYrmr2uHfpvDwMFGy32wZYkmNaVjqjS2M0p6ggaOA',

        ];
        $url = $baseUrl . '?' . http_build_query($queryParams);
        $client = HttpClient::create();
        $response = $client->request('GET', $url);
//        dd($url);
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        $contentArray = json_decode($content, true);
//        dd($contentArray);
        return $this->render('rideshare/index.html.twig', [
            'controller_name' => 'SearchController',
            'content' => $contentArray,
        ]);

    }


}
