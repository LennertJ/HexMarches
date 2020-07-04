<?php

namespace App\Repository;

use App\Entity\SessionRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SessionRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method SessionRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method SessionRequest[]    findAll()
 * @method SessionRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SessionRequest::class);
    }

    // /**
    //  * @return SessionRequest[] Returns an array of SessionRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SessionRequest
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
