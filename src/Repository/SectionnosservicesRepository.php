<?php

namespace App\Repository;

use App\Entity\Sectionnosservices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sectionnosservices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sectionnosservices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sectionnosservices[]    findAll()
 * @method Sectionnosservices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionnosservicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sectionnosservices::class);
    }

    // /**
    //  * @return Sectionnosservices[] Returns an array of Sectionnosservices objects
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
    public function findOneBySomeField($value): ?Sectionnosservices
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
