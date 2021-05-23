<?php

namespace App\Repository;

use App\Entity\POEBaseAffixes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method POEBaseAffixes|null find($id, $lockMode = null, $lockVersion = null)
 * @method POEBaseAffixes|null findOneBy(array $criteria, array $orderBy = null)
 * @method POEBaseAffixes[]    findAll()
 * @method POEBaseAffixes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class POEBaseAffixesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, POEBaseAffixes::class);
    }

    // /**
    //  * @return POEBaseAffixes[] Returns an array of POEBaseAffixes objects
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
    public function findOneBySomeField($value): ?POEBaseAffixes
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
