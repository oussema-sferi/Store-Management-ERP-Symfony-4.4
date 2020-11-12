<?php

namespace App\Repository;

use App\Entity\OrderList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderList|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderList|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderList[]    findAll()
 * @method OrderList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderList::class);
    }

    // /**
    //  * @return OrderList[] Returns an array of OrderList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderList
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
