<?php

namespace App\Repository;

use App\Entity\Sectioncarousel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sectioncarousel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sectioncarousel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sectioncarousel[]    findAll()
 * @method Sectioncarousel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectioncarouselRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sectioncarousel::class);
    }

    // /**
    //  * @return Sectioncarousel[] Returns an array of Sectioncarousel objects
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
    public function findOneBySomeField($value): ?Sectioncarousel
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
