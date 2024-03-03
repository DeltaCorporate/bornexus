<?php

namespace App\Twig\Components;

use App\Repository\SuppliersRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class SupplierDatatable
{
    use DefaultActionTrait;

    #[LiveProp(hydrateWith: 'hydrate', dehydrateWith: 'dehydrate')]
    public array $data = [];

    public array $headers = ['Nom', 'Site'];

    #[LiveProp(writable: true)]
    public array $selected = [];

    public int $itemsPerPage = 15;

    public int $totalPages = 0;

    #[LiveProp]
    public int $currentPage = 1;

    public int $total = 0;

    public function __construct(private readonly Security $security, private readonly SuppliersRepository $suppliersRepository)
    {
        $this->total = $this->suppliersRepository->count([]);
        $this->totalPages = ceil($this->total / $this->itemsPerPage);
        $this->data = $this->getData();
    }

    private function getTotalPages(): int
    {
        return ceil($this->total / $this->itemsPerPage);
    }

    public function getData(): array
    {
        $offset = ($this->currentPage - 1) * $this->itemsPerPage;
        return $this->suppliersRepository->findBy([], ['id' => 'ASC'], $this->itemsPerPage, $offset);
    }

    #[LiveAction]
    public function nextPage(): void
    {
        $this->currentPage++;
    }

    #[LiveAction]
    public function prevPage(): void
    {
        $this->currentPage--;
    }

    #[LiveAction]
    public function deleteData(): void
    {
        foreach ($this->selected as $id) {
            $item = $this->suppliersRepository->find($id);
            if ($item) {
                $this->suppliersRepository->remove($item);
            }
        }
        $this->selected = [];
        $this->total = $this->suppliersRepository->count([]);
        $this->totalPages = $this->getTotalPages();
        $this->data = $this->getData();
    }

    public function dehydrate(array $data): string
    {
        return serialize($data);
    }

    public function hydrate(string $data): array
    {
        return unserialize($data);
    }
}
