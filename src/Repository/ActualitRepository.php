<?php

namespace App\Repository;

use App\Entity\Actualit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Actualit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actualit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actualit[]    findAll()
 * @method Actualit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actualit::class);
    }

    // /**
    //  * @return Actualit[] Returns an array of Actualit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Actualit
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
