<?php

namespace App\Repository;

use App\Entity\POEBaseAffixesTier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method POEBaseAffixesTier|null find($id, $lockMode = null, $lockVersion = null)
 * @method POEBaseAffixesTier|null findOneBy(array $criteria, array $orderBy = null)
 * @method POEBaseAffixesTier[]    findAll()
 * @method POEBaseAffixesTier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class POEBaseAffixesTierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, POEBaseAffixesTier::class);
    }

    // /**
    //  * @return POEBaseAffixesTier[] Returns an array of POEBaseAffixesTier objects
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
    public function findOneBySomeField($value): ?POEBaseAffixesTier
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
