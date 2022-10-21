<?php

namespace App\Repository;

use App\Entity\Sectiondevi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sectiondevi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sectiondevi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sectiondevi[]    findAll()
 * @method Sectiondevi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectiondeviRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sectiondevi::class);
    }

    // /**
    //  * @return Sectiondevi[] Returns an array of Sectiondevi objects
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
    public function findOneBySomeField($value): ?Sectiondevi
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
