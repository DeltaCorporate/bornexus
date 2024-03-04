<?php
namespace App\Twig\Components\Billing;

use App\Repository\BillingsRepository;
use App\Twig\Components\Traits\TableTrait;
use Doctrine\ORM\EntityManagerInterface;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\Serializer\SerializerInterface;

#[AsLiveComponent(template: 'billing/components/billing_table.html.twig')]
class BillingTable extends AbstractController
{

    use DefaultActionTrait;
    use TableTrait;



    public function __construct(
        private BillingsRepository $dataRepository,
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator,
        private SerializerInterface $serializer,
        private RequestStack $requestStack
    ){
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }


    #[LiveAction]
    public function deleteBilling(#[LiveArg] int $id): void
    {

        $billing = $this->dataRepository->find($id);
        if ($billing) {
            $this->dataRepository->delete($billing);
            $this->entityManager->flush();
            $this->paginate();
            $this->data = array_filter($this->data, function ($billing) use ($id) {
                return $billing['id'] != $id;
            });
        }

    }
    final public function paginate()
    {
        $type = $this->requestStack->getCurrentRequest()->query->get('type') ?? 'quote';
        $data = $this->paginator->paginate(
            $this->dataRepository->getBillingsByType($type),
            $this->page,
            10
        );
        $this->pageCount = $data->getPageCount();

        return $data;
    }

    public function loadData(): void{

        $billings = $this->paginate();
       $billingsItems =  array_map(function ($billing){
            $billing->calculTotalPrices();
            return [
              'id' => $billing->getId(),
              'typeFirstLetter' => $billing->getTypeFirstLetter(),
              'emitedAt' => $billing->getEmitedAt(),
                'priceTtcDiscounted' => $billing->getPriceTtcDiscounted(),
                'statusLabel' => $billing->getStatusLabel(),
                'clientFullName' => $billing->getUsers()->getFullName(),
                'client_id' => $billing->getUsers()->getId(),
                'status' => $billing->getStatus()
            ];
        },$billings->getItems());
        $this->data = $billingsItems;
    }


}
