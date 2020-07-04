<?php

namespace App\Repository;

use App\Entity\CharacterSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CharacterSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterSession[]    findAll()
 * @method CharacterSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterSession::class);
    }

    // /**
    //  * @return CharacterSession[] Returns an array of CharacterSession objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CharacterSession
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
