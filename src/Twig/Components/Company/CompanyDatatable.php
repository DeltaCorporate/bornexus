<?php

namespace App\Twig\Components\Company;

use App\Repository\CompaniesRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class CompanyDatatable
{
    use DefaultActionTrait;
    public array $companies = [];
    public array $headers = ['Nom', 'Siret',"Date d'inscription",'Clients', 'Statut'];
    public int $totalCompanies = 0;

    public function __construct(CompaniesRepository $companiesRepository)
    {
        $this->companies = $companiesRepository->findAll();
        $this->totalCompanies = $companiesRepository->count([]);

    }
}
