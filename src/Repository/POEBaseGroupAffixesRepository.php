<?php

namespace App\Repository;

use App\Entity\POEBaseGroupAffixes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method POEBaseGroupAffixes|null find($id, $lockMode = null, $lockVersion = null)
 * @method POEBaseGroupAffixes|null findOneBy(array $criteria, array $orderBy = null)
 * @method POEBaseGroupAffixes[]    findAll()
 * @method POEBaseGroupAffixes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class POEBaseGroupAffixesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, POEBaseGroupAffixes::class);
    }

    // /**
    //  * @return POEBaseGroupAffixes[] Returns an array of POEBaseGroupAffixes objects
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
    public function findOneBySomeField($value): ?POEBaseGroupAffixes
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
