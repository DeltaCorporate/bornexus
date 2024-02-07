<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\BillingsCompanyCatalogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillingsCompanyCatalogRepository::class)]
class BillingCompanyCatalog
{
    use Timestampable;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $discount = null;

    #[ORM\ManyToOne(inversedBy: 'billingsCompanyCatalogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Billing $billing = null;

    #[ORM\ManyToOne(inversedBy: 'billingsCompanyCatalogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyCatalog $company_catalog = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(string $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getBilling(): ?Billing
    {
        return $this->billing;
    }

    public function setBilling(?Billing $billing): static
    {
        $this->billing = $billing;

        return $this;
    }

    public function getCompanyCatalog(): ?CompanyCatalog
    {
        return $this->company_catalog;
    }

    public function setCompanyCatalog(?CompanyCatalog $company_catalog): static
    {
        $this->company_catalog = $company_catalog;

        return $this;
    }
}
