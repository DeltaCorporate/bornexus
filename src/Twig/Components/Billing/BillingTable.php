<?php
namespace App\Twig\Components\Billing;

use App\Repository\BillingsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\Serializer\SerializerInterface;

#[AsLiveComponent(template: 'billing/components/billing_table.html.twig')]
class BillingTable
{

    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public int $page = 1;

    #[LiveProp(writable: true, hydrateWith: 'hydrateBillings',dehydrateWith: 'dehydrateBillings' )]
    public array $billings = [];

    #[LiveProp]
    public $pageCount;


    public function __construct(
        private BillingsRepository $billingsRepository,
        private PaginatorInterface $paginator,
        private SerializerInterface $serializer

    ){
    }

    public function mount(): void
    {
        $this->loadBillings();
    }
    public function dehydrateBillings(array $billings): string
    {
        return serialize($billings);
    }

    public function hydrateBillings(string $data): array
    {
        return unserialize($data);
    }
    #[LiveAction]
    public function nextPage(): void {
        $this->page++;
        $this->loadBillings();
    }

    public function loadBillings(): void{
        $billings = $this->paginator->paginate(
            $this->billingsRepository->listPaginationQuery(),
            $this->page,
            10
        );
        $this->pageCount = $billings->getPageCount();

       $billingsItems =  array_map(function ($billing){
            $billing->calculTotalPrices();
            return [
              'id' => $billing->getId(),
              'typeFirstLetter' => $billing->getTypeFirstLetter(),
              'emitedAt' => $billing->getEmitedAt(),
                'priceTtcDiscounted' => $billing->getPriceTtcDiscounted(),
                'statusLabel' => $billing->getStatusLabel(),
                'clientFullName' => $billing->getUsers()->getFullName(),
                'status' => $billing->getStatus()
            ];
        },$billings->getItems());
        $this->billings = array_merge($this->billings,$billingsItems);

    }
}
