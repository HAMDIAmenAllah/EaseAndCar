<?php

namespace App\Repository;

use App\Entity\Sectionnosengagements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sectionnosengagements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sectionnosengagements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sectionnosengagements[]    findAll()
 * @method Sectionnosengagements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionnosengagementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sectionnosengagements::class);
    }

    // /**
    //  * @return Sectionnosengagements[] Returns an array of Sectionnosengagements objects
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
    public function findOneBySomeField($value): ?Sectionnosengagements
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
