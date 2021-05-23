<?php

namespace App\Repository;

use App\Entity\POEBaseGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method POEBaseGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method POEBaseGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method POEBaseGroup[]    findAll()
 * @method POEBaseGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class POEBaseGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, POEBaseGroup::class);
    }

    // /**
    //  * @return POEBaseGroup[] Returns an array of POEBaseGroup objects
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
    public function findOneBySomeField($value): ?POEBaseGroup
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
