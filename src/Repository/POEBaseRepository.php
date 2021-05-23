<?php

namespace App\Repository;

use App\Entity\POEBase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method POEBase|null find($id, $lockMode = null, $lockVersion = null)
 * @method POEBase|null findOneBy(array $criteria, array $orderBy = null)
 * @method POEBase[]    findAll()
 * @method POEBase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class POEBaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, POEBase::class);
    }

    // /**
    //  * @return POEBase[] Returns an array of POEBase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?POEBase
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
