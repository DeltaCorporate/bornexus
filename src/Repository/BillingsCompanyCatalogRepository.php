<?php

namespace App\Repository;

use App\Entity\BillingsCompanyCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BillingsCompanyCatalog>
 *
 * @method BillingsCompanyCatalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method BillingsCompanyCatalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method BillingsCompanyCatalog[]    findAll()
 * @method BillingsCompanyCatalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillingsCompanyCatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BillingsCompanyCatalog::class);
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
