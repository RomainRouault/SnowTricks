<?php

namespace App\Repository;

use App\Entity\Tricj;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tricj|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tricj|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tricj[]    findAll()
 * @method Tricj[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TricjRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tricj::class);
    }

//    /**
//     * @return Tricj[] Returns an array of Tricj objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tricj
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
