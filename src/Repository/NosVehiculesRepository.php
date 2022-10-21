<?php

namespace App\Repository;

use App\Entity\NosVehicules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NosVehicules|null find($id, $lockMode = null, $lockVersion = null)
 * @method NosVehicules|null findOneBy(array $criteria, array $orderBy = null)
 * @method NosVehicules[]    findAll()
 * @method NosVehicules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NosVehiculesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NosVehicules::class);
    }

    // /**
    //  * @return NosVehicules[] Returns an array of NosVehicules objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NosVehicules
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
