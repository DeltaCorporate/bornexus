<?php
namespace App\Twig\Components\Billing;

use App\Repository\BillingsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;


#[AsLiveComponent(template: 'billing/components/billing_table.html.twig')]
class BillingTable
{

    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public int $page = 1;
    
    public function __construct(
          private BillingsRepository $billingsRepository,
          private PaginatorInterface $paginator
    ){
    }
     public function getBillings()
     {
       
        $billings = $this->paginator->paginate(
            $this->billingsRepository->listPaginationQuery(),
            $this->page,
            10
        );

        $billingsItems = $billings->getItems();
        
          array_map(function ($billing){
             $billing->calculTotalPrices();
          }, $billingsItems);

        return $billings;
    }

    #[LiveAction]
    public function nextPage(): void {
        $this->page++;
    }
}
