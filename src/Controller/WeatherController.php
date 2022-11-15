<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;
use App\Entity\Data;
use App\Repository\CityRepository;
use App\Repository\DataRepository;
use App\Service\WeatherUtil;

class WeatherController extends AbstractController
{
    //stara funkcja bez serwisu
    // public function cityAction($localisationId, DataRepository $measuresRepository, CityRepository $localisationRepository): Response
    // {
    //     $localisation = $localisationRepository->find($localisationId);
    //     //$localisation2 = $localisationRepository->find($city);
	// 	$measures = $measuresRepository->findByLocation($localisation, $localisationRepository);
		
    //     return $this->render('weather/index.html.twig', [
    //         'city' => $localisation,
	// 		'data' => $measures,
    //     ]);
    // }

    //nowa funkcja z serwisem
    public function cityAction($countryCode, $city, DataRepository $dataRepo, CityRepository $cityRepo, WeatherUtil $weatherU): Response
    {
		$data = $weatherU->getWeatherForCountryAndCity($countryCode, $city);
        return $this->render('weather/index.html.twig', [
			'data' => $data,
        ]);
    }
}
