<?php

namespace App\Repository;

use App\Entity\AttendanceConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttendanceConfiguration|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttendanceConfiguration|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttendanceConfiguration[]    findAll()
 * @method AttendanceConfiguration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendanceConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttendanceConfiguration::class);
    }

    // /**
    //  * @return AttendanceConfiguration[] Returns an array of AttendanceConfiguration objects
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
    public function findOneBySomeField($value): ?AttendanceConfiguration
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
