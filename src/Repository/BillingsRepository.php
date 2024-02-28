<?php

namespace App\Repository;

use App\Entity\Billing;
use App\Entity\BillingCompanyCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

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
      private ManagerRegistry $registry,
      private Security $security
    )
    {
        parent::__construct($registry, Billing::class);
    }


    public function listPaginationQuery(){
        return $this->createQueryBuilder('b')
            ->where('b.company = :company')
            ->setParameter('company', $this->security->getUser()->getCompany())
            ->orderBy('b.id', 'ASC')
            ->getQuery();
    }

    public function delete(Billing $billing): void{

        $catalogs = $this->entityManager->getRepository(BillingCompanyCatalog::class)->findBy(['billing' => $billing]);
        foreach ($catalogs as $catalog)
            $this->entityManager->remove($catalog);

        $this->entityManager->remove($billing);

    }
}
