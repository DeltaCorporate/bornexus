<?php
namespace App\Twig\Components\Billing;

use App\Repository\BillingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
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
        private EntityManagerInterface $entityManager,
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

    #[LiveAction]
    public function previousPage(): void {
        $this->page--;
        $this->loadBillings();
    }

    #[LiveAction]
    public function deleteBilling(#[LiveArg] int $id): void
    {

        $billing = $this->billingsRepository->find($id);
        if ($billing) {
            $this->billingsRepository->delete($billing);
            $this->paginateBilling();
            $this->billings = array_filter($this->billings, function ($billing) use ($id) {
                return $billing['id'] != $id;
            });
        }

    }


    public function paginateBilling()
    {
        $billings = $this->paginator->paginate(
            $this->billingsRepository->listPaginationQuery(),
            $this->page,
            10
        );
        $this->pageCount = $billings->getPageCount();

        return $billings;
    }
    public function loadBillings(): void{
        $billings = $this->paginateBilling();

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
        $this->billings = $billingsItems;
    }


}
