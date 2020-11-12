<?php

namespace App\Repository;

use App\Entity\SalaryBonus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SalaryBonus|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalaryBonus|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalaryBonus[]    findAll()
 * @method SalaryBonus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalaryBonusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalaryBonus::class);
    }

    // /**
    //  * @return SalaryBonus[] Returns an array of SalaryBonus objects
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
    public function findOneBySomeField($value): ?SalaryBonus
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
