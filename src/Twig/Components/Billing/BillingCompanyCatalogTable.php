<?php
namespace App\Twig\Components\Billing;

use App\Form\BillingCompanyCatalogType;
use App\Repository\BillingsRepository;
use App\Twig\Components\Traits\TableTrait;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
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

    #[LiveAction]
    public function addItem(){
        dd($this->data);
    }

    public function loadData(): void {

        $billingCompanyCatalogs = $this->billing->getBillingsCompanyCatalogs();
        $this->data = $billingCompanyCatalogs->count() > 0 ? $billingCompanyCatalogs->toArray() : [];

    }


}
