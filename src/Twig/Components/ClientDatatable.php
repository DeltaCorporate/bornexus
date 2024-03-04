<?php

namespace App\Twig\Components;

use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ClientDatatable
{
    use DefaultActionTrait;

    #[LiveProp(hydrateWith: 'hydrate', dehydrateWith: 'dehydrate')]
    public array $data = [];

    public array $headers = ['Nom', 'Prénom', 'Email', 'Téléphone'];

    #[LiveProp(writable: true)]
    public array $selected = [];

    public int $itemsPerPage = 15;

    public int $totalPages = 0;
    #[LiveProp]
    public int $currentPage = 1;

    public int $total = 0;

    public function __construct(private readonly Security $security, private readonly UserRepository $userRepository)
    {

        $this->total = $this->userRepository->findByCompanyAndRole($this->security->getUser()->getCompany(), 'ROLE_USER')->count();
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

        $company = $this->security->getUser()->getCompany();
        return $this->userRepository->findByCompanyAndRole($company, 'ROLE_USER', $this->itemsPerPage, $offset)->toArray();
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
            $user = $this->userRepository->find($id);
            if ($user) {
                $this->userRepository->remove($user);
            }
        }
        $this->selected = [];
        $this->total = $this->userRepository->count(['company' => $this->security->getUser()->getCompany()]);
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
