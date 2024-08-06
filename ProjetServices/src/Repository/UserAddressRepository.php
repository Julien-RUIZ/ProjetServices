<?php

namespace App\Repository;

use App\Entity\UserAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserAddress>
 *
 * @method UserAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAddress[]    findAll()
 * @method UserAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAddress::class);
    }


    public function findByUserId($userid): array
    {
        return $this->createQueryBuilder('u')
             ->select('u')
             ->setParameter('userid', $userid)
             ->where('u.user = :userid')
             ->getQuery()
             ->getResult();
    }

    /**
     * @return array
     */
    public function findmainaddress()
    {
        return $this->createQueryBuilder('u')
            ->select('u.mainAddress', 'u.Address')
            ->getQuery()
            ->getResult();
    }

    public function paginateUserAddress($page, int $limit, $userid):Paginator
    {
        return new Paginator(
            $this->createQueryBuilder('u')
                ->setParameter('userid', $userid)
                ->where('u.user = :userid')
                ->orderBy('u.mainAddress', 'DESC')
                ->setFirstResult(($page-1)*$limit)
                ->setMaxResults($limit)
                ->getQuery()
                ->setHint(Paginator::HINT_ENABLE_DISTINCT, false)
        );
    }

    public function findAddressAndServiceByUserid($userid): array
    {
        return $this->createQueryBuilder('u')
            ->select('u','s')
            ->leftJoin('u.service', 's' )
            ->setParameter('userid', $userid)
            ->where('u.user = :userid')
            ->orderBy('u.mainAddress', 'DESC')
            ->getQuery()
            ->getResult();
    }

}
