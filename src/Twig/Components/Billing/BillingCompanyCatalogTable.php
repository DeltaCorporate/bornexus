<?php
namespace App\Twig\Components\Billing;

use App\Entity\BillingCompanyCatalog;
use App\Entity\CompanyCatalog;
use App\Form\BillingCompanyCatalogType;
use App\Repository\BillingsRepository;
use App\Twig\Components\Traits\TableTrait;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveListener;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Billing;

#[AsLiveComponent(template: 'billing/components/billing_company_catalog_table.html.twig')]
class BillingCompanyCatalogTable
{

    use DefaultActionTrait;
    use TableTrait;


    #[LiveProp]
    public ?Billing $billing;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,
        private SerializerInterface $serializer,
    ){}

    public function mount(Billing $billing){
        $this->billing = $billing;
        $this->loadData();
    }


    #[LiveListener('line_item:save')]
    public function refreshLineItemSaved(#[LiveArg] string $billingCompanyCatalog): void
    {
        $billingCompanyCatalog = unserialize($billingCompanyCatalog);
        $this->data = array_map(function ($item) use ($billingCompanyCatalog){
              if($item->getId() === $billingCompanyCatalog->getId())
                  $item = $billingCompanyCatalog;
              return $item;
          },$this->data);
    }

    #[LiveListener('line_item:delete')]
    public function refreshLineItemDeleted(#[LiveArg] int $billingCompanyCatalogId): void
    {

        foreach($this->data as $key => $item){
            if($item->getId() === $billingCompanyCatalogId)
                unset($this->data[$key]);

        }

        $this->data = array_values($this->data);
    }

    #[LiveAction]
    public function addItem(): void
    {

        $billingCompanyCatalog = new BillingCompanyCatalog();
        $billingCompanyCatalog->setBilling($this->billing);
        $billingCompanyCatalog->setQuantity(1);
        $billingCompanyCatalog->setDiscount(0);
        $this->entityManager->persist($billingCompanyCatalog);
        $this->entityManager->flush();
        $this->data[] = $billingCompanyCatalog;
    }

    public function loadData(): void {

        $billingCompanyCatalogs = $this->billing->getBillingsCompanyCatalogs();
        $this->data = $billingCompanyCatalogs->count() > 0 ? $billingCompanyCatalogs->toArray() : [];

    }


}
