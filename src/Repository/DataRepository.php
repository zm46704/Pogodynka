<?php

namespace App\Repository;

use App\Entity\Data;
use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CityRepository;


class DataRepository extends ServiceEntityRepository
{
	private CityRepository $cityRepo;
    public function __construct(ManagerRegistry $registry, CityRepository $cityRepo)
    {
        parent::__construct($registry, Data::class);
		$this->cityRepo = $cityRepo;
    }

    public function findByLocation(City $localisation)
	{
		$local = $this->cityRepo->find($localisation);
		//$localisation = $localisationRepository->find($countryID, $city);

		$qb = $this->createQueryBuilder('m');
		$qb->where('m.city = :city')
			->setParameter('city', $local);
			//->where('r.city_ID = :localisation')
			//->setParameter('localisation', $localisation);
			//->andWhere('m.city = :city')
			//->setParameter('city', $localisation);
			//join('m.city', 'r')
			
		$query = $qb->getQuery();
		$result = $query->getResult();
		
		return $result;
	}
}