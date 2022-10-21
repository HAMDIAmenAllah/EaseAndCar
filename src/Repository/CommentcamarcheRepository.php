<?php

namespace App\Repository;

use App\Entity\Commentcamarche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentcamarche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentcamarche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentcamarche[]    findAll()
 * @method Commentcamarche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentcamarcheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentcamarche::class);
    }

    // /**
    //  * @return Commentcamarche[] Returns an array of Commentcamarche objects
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
    public function findOneBySomeField($value): ?Commentcamarche
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
