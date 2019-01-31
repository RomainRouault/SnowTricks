<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    public function getTrickList() : array
    {
       return $this->findAll();

    }


//    /**
//     * @return Trick[] Returns an array of Trick objects
//     */
    public function findByField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneBySomeField($field, $value): ?Trick
    {
        try {
            return $this->createQueryBuilder('t')
                ->andWhere('t.'. $field .' = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        }
        catch(DBALException $e)
            {
                $errorMessage = $e->getMessage();
            }
        catch(\Exception $e)
            {
                $errorMessage = $e->getMessage();
            }

    }
}
