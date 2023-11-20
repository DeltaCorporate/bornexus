<?php

namespace App\Repository;

use App\Entity\Billings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Billings>
 *
 * @method Billings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billings[]    findAll()
 * @method Billings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billings::class);
    }

//    /**
//     * @return Billings[] Returns an array of Billings objects
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

//    public function findOneBySomeField($value): ?Billings
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
