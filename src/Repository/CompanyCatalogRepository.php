<?php

namespace App\Repository;

use App\Entity\CompanyCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyCatalog>
 *
 * @method CompanyCatalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyCatalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyCatalog[]    findAll()
 * @method CompanyCatalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyCatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyCatalog::class);
    }

//    /**
//     * @return CompanyCatalog[] Returns an array of CompanyCatalog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CompanyCatalog
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
