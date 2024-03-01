<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyCatalog;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
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
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, $entityManager)
    {
        parent::__construct($registry, CompanyCatalog::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @throws ORMException
     */
    public function getFavoriteProducts($companyId)
    {
        $companyCatalog = $this->entityManager->getReference(CompanyCatalog::class, $companyId);
        return $companyCatalog->getFavoriteProducts();
    }

    /**
     * @throws ORMException
     */
    public function addFavoriteProduct($productId, $companyId)
    {
        $companyId = $this->find($companyId);
        $companyCatalog = $this->entityManager->getReference(CompanyCatalog::class, $companyId);
        $product = $this->entityManager->getReference(Product::class, $productId);

        $companyCatalog->addFavoriteProduct($product);

        $this->entityManager->flush();
    }

    /**
     * @throws ORMException
     */
    public function removeFavoriteProduct($productId, $companyId)
    {
        $companyCatalog = $this->entityManager->getReference(CompanyCatalog::class, $companyId);
        $product = $this->entityManager->getReference(Product::class, $productId);

        $companyCatalog->removeFavoriteProduct($product);

        $this->entityManager->flush();
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
