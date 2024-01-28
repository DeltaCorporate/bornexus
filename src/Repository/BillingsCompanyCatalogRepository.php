<?php

namespace App\Repository;

use App\Entity\BillingCompanyCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BillingCompanyCatalog>
 *
 * @method BillingCompanyCatalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method BillingCompanyCatalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method BillingCompanyCatalog[]    findAll()
 * @method BillingCompanyCatalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillingsCompanyCatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BillingCompanyCatalog::class);
    }

//    /**
//     * @return BillingsCompanyCatalog[] Returns an array of BillingsCompanyCatalog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BillingsCompanyCatalog
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
