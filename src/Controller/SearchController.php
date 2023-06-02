<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpClient\HttpClient;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
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
        $totalAdults = 0;
        $totalChildren = 0;

        $quant = $request->request->get('quant');
        if ($quant !== null) {
            if (isset($quant[1])) {
                $totalAdults = $quant[1];
            }
            if (isset($quant[2])) {
                $totalChildren = $quant[2];
            }
        }
        $adaAssistance = $request->request->get('adaAssistance');
        $fromDateTime = $request->request->get('from');
        $toDateTime = $request->request->get('to_date');

        $dateString = $fromDateTime;
        $date = DateTime::createFromFormat('Y-m-d H:i', $dateString);
        if ($date !== false) {
            $fromDate = $date->format('m/d/Y h:i A');
        } else {
            // Handle the case where $date is not a valid DateTime object
            $fromDate = 'Invalid date';
        }

        $toDateString = $toDateTime;
        $date = DateTime::createFromFormat('Y-m-d H:i', $toDateString);

        if ($date !== false) {
            $toDate = $date->format('m/d/Y h:i A');
        } else {
            return $this->redirectToRoute('app_home');
        }

        $baseUrl = 'https://elimousines.net/search-result';
        $queryParams = [
            'fromCity' => $fromCity,
            'toCity' =>  $toCity,
            'from_city_Lat' => $fromCityLat,
            'from_city_Lng' =>  $fromCityLng,
            'to_city_Lat' => $toCityLat,
            'to_city_Lng' =>  $toCityLng,
            'from' => $fromDate,
            'to_date' => $toDate,
            'vehicleCategory' => $vehicleCategory,
            'ada' => $adaAssistance,
            'jwt' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTEsImV4cCI6NTI2MDI4NjQ3M30.3yuYrmr2uHfpvDwMFGy32wZYkmNaVjqjS2M0p6ggaOA',
            'total_adults' => $totalAdults,
            'total_children' => $totalChildren,
        ];
        $url = $baseUrl . '?' . http_build_query($queryParams);
        $client = HttpClient::create();
        $response = $client->request('GET', $url);
//        dd($url);
        $statusCode = $response->getStatusCode();
        $content = $response->getContent();

        $contentArray = json_decode($content, true);
//        dd($contentArray);
        return $this->render('trip/index.html.twig', [
            'controller_name' => 'SearchController',
            'content' => $contentArray,
        ]);

    }

    private function url2png_v6($url) //, $args = []
    {
        $URL2PNG_APIKEY = "PC1EA5686B79A9D";
        $URL2PNG_SECRET = "S_FDE718096BFD5";

        # urlencode request target
        $options['url'] = urlencode($url);
        # usage
        $options['unique'] = round(time() / 60 / 60, 0);      # Limit capture to once per hour
        $options['fullpage'] = 'false';      # [true,false] Default: false
        $options['thumbnail_max_width'] = 'false';      # scaled image width in pixels; Default no-scaling.
        $options['viewport'] = "1280x1024";  # Max 5000x5000; Default 1280x1024

//        $options += $args;

        # create the query string based on the options
        foreach ($options as $key => $value) {
            $_parts[] = "$key=$value";
        }

        # create a token from the ENTIRE query string
        $query_string = implode("&", $_parts);
        $TOKEN = md5($query_string . $URL2PNG_SECRET);

        return "https://api.url2png.com/v6/$URL2PNG_APIKEY/$TOKEN/png/?$query_string";
    }
}
