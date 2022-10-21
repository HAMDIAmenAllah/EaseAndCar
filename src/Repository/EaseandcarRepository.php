<?php

namespace App\Repository;

use App\Entity\Easeandcar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Easeandcar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Easeandcar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Easeandcar[]    findAll()
 * @method Easeandcar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EaseandcarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Easeandcar::class);
    }

    // /**
    //  * @return Easeandcar[] Returns an array of Easeandcar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Easeandcar
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
