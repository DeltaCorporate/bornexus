<?php

namespace App\Repository;

use App\Entity\Billing;
use App\Entity\BillingCompanyCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Billing>
 *
 * @method Billing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billing[]    findAll()
 * @method Billing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillingsRepository extends ServiceEntityRepository
{
    public function __construct(
      private  EntityManagerInterface $entityManager,
      private ManagerRegistry $registry)
    {
        parent::__construct($registry, Billing::class);
    }


    public function listPaginationQuery(){
        return $this->createQueryBuilder('b')
            ->orderBy('b.id', 'ASC')
            ->getQuery();
    }

    public function delete(Billing $billing): void{

        $catalogs = $this->entityManager->getRepository(BillingCompanyCatalog::class)->findBy(['billing' => $billing]);
        foreach ($catalogs as $catalog)
            $this->entityManager->remove($catalog);


        $this->entityManager->remove($billing);
        $this->entityManager->flush();

    }
}
