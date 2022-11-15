<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;
use App\Entity\Data;
use App\Repository\CityRepository;
use App\Repository\DataRepository;

class WeatherUtil
{
    private CityRepository $cityRepo;
    private DataRepository $dataRepo;
    public function __construct(CityRepository $cityRepo, DataRepository $dataRepo){
        $this->dataRepo = $dataRepo;
        $this->cityRepo = $cityRepo;
    }
    public function getWeatherForCountryAndCity($countryCode, $city): array
    {
        $local = $this->cityRepo->findOneBy(
            [
                "name" => $city,
                "countryID" => $countryCode,
            ]
            );
        $data = $this->getWeatherForLocation($local);

        return $data;
    }

    public function getWeatherForLocation(City $localisation)
    {
        $data = $this->dataRepo->findByLocation($localisation);
        
        return $data;
    }

    public function getWeatherForCommand($locationId):array
    {
        $location = $this->cityRepo->find($locationId);

        $datas = $this->dataRepo->findByLocation($location);

        $results = [
            'name' => $location->getName(),
            'country' => $location->getCountryID(),
            'data' => [],
        ];

        foreach ($datas as $data) {
            $resultData = [
                'date' => $data->getDate()->format('Y-m-d'),
                'temperature' => $data->getTemperature(),
            ];
            $results['datas'][] = $resultData;
        }

        return $results;
    }
}


