<?php

namespace App\Repository;

use App\Entity\Billing;
use App\Entity\BillingCompanyCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
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

    public function updatePriceStatus(Billing $billing){

        $billing->calculTotalPrices();
        $statusOrigine = $billing->getStatus();
        if ($billing->getType() === 'quote') {
            $billing->setStatus('');
        }else{
            $priceTtcDiscounted = $billing->getPriceTtcDiscounted();
            $amountPaid = (float)$billing->getAmountPaid();

            if ($amountPaid < $priceTtcDiscounted)
                $billing->setStatus('unpaid');
            else
                $billing->setStatus('paid');
        }

        if($statusOrigine !== $billing->getStatus())
            $this->entityManager->flush();

        return $billing;
    }

    public function listPaginationQuery(){
        return $this->createQueryBuilder('b')
            ->where('b.company = :company')
            ->setParameter('company', $this->security->getUser()->getCompany())
            ->orderBy('b.id', 'ASC')
            ->getQuery();
    }

    public function getBillingFromToken(string $billingToken): ?Billing{
        $token = Billing::extractToken($billingToken);
        return $this->findOneBy(['id' => $token['id'],'uuid' => $token['uuid']]);
    }

    /**
     * @param Billing $billing
     * @param string $type
     * @return Billing
     * @throws \Exception
     */
    public function cloneBilling(Billing $billing,string $type = 'quote'): Billing{
        if(!array_key_exists($type,Billing::TYPE))
            throw new \Exception('Le type de facturation n\'est pas correct');

        if (!$billing->getId())
            throw new EntityNotFoundException('La facture demandée n\'existe pas.');


        $clonedBilling = clone $billing;
        $clonedBilling->setType($type);
        $this->entityManager->persist($clonedBilling);
        $this->entityManager->flush();

        return $clonedBilling;
    }
    public function delete(Billing $billing): void{

        $catalogs = $this->entityManager->getRepository(BillingCompanyCatalog::class)->findBy(['billing' => $billing]);
        foreach ($catalogs as $catalog)
            $this->entityManager->remove($catalog);

        $this->entityManager->remove($billing);

    }
}
