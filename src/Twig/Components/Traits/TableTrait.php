<?php

namespace App\Twig\Components\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

trait TableTrait
{


    #[LiveProp(writable: true, hydrateWith: 'hydrate',dehydrateWith: 'dehydrate' )]
    public array $data = [];

    #[LiveProp]
    public $pageCount;


    #[LiveProp(writable: true)]
    public int $page = 1;



    public function dehydrate(array $data): string
    {
        return serialize($data);
    }

    public function hydrate(string $data): array
    {
        return unserialize($data);
    }

    public function mount(): void
    {
        $this->loadData();
    }
    public function paginate()
    {
        $data = $this->paginator->paginate(
            $this->dataRepository->listPaginationQuery(),
            $this->page,
            10
        );
        $this->pageCount = $data->getPageCount();

        return $data;
    }
    #[LiveAction]
    public function nextPage(): void {
        $this->page++;
        $this->loadData();
    }

    #[LiveAction]
    public function previousPage(): void {
        $this->page--;
        $this->loadData();
    }

}