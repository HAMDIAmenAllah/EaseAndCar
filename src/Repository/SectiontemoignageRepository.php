<?php

namespace App\Repository;

use App\Entity\Sectiontemoignage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sectiontemoignage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sectiontemoignage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sectiontemoignage[]    findAll()
 * @method Sectiontemoignage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectiontemoignageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sectiontemoignage::class);
    }

    // /**
    //  * @return Sectiontemoignage[] Returns an array of Sectiontemoignage objects
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
    public function findOneBySomeField($value): ?Sectiontemoignage
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
