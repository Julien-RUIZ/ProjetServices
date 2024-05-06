<?php

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function finduser1($idService){
        return $this->createQueryBuilder('s')
            ->select( 's','ua','u')
            ->leftJoin('s.userAddress', 'ua')
            ->leftJoin('ua.user', 'u')
            ->setParameter('idService', $idService)
            ->where('s.id = :idService')
            ->getQuery()
            ->getResult();
    }
    public function finduser($idService){
        return $this->getEntityManager()->createQuery(<<<DQL
        SELECT s, ua, u
        FROM App\Entity\Service as s
        LEFT JOIN s.userAddress as ua
        LEFT JOIN ua.user as u
        WHERE :idService = s.id
    DQL)
            ->setParameter('idService', $idService)
            ->getResult();
    }


}
