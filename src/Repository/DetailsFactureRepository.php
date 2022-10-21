<?php

namespace App\Repository;

use App\Entity\DetailsFacture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailsFacture|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailsFacture|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailsFacture[]    findAll()
 * @method DetailsFacture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailsFactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailsFacture::class);
    }

    // /**
    //  * @return DetailsFacture[] Returns an array of DetailsFacture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailsFacture
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
