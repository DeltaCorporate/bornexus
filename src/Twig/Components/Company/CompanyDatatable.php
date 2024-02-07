<?php

namespace App\Twig\Components\Company;

use App\Repository\CompaniesRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class CompanyDatatable
{
    use DefaultActionTrait;

    #[LiveProp]
    public int $currentPage = 1;

    public int $itemsPerPage = 15;


    public array $companies = [];
    public array $headers = ['Nom', "Date d'inscription", 'Clients', 'Statut'];

    #[LiveProp(writable: true)]
    public array $companyIds = [];
    public int $totalCompanies = 0;
    public int $totalPages = 0;

    public function __construct(private readonly CompaniesRepository $companiesRepository)
    {
        $this->totalCompanies = $companiesRepository->count([]);
        $this->totalPages = $this->getTotalPages();
    }

    public function getCompanies(): array
    {
        $offset = ($this->currentPage - 1) * $this->itemsPerPage;
        return $this->companiesRepository->findBy([], null, $this->itemsPerPage, $offset);
    }

    public function getTotalPages(): int
    {
        return ceil($this->totalCompanies / $this->itemsPerPage);
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
}
