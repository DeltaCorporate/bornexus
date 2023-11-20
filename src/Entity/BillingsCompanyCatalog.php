<?php

namespace App\Entity;

use App\Repository\BillingsCompanyCatalogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillingsCompanyCatalogRepository::class)]
class BillingsCompanyCatalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $billing_id = null;

    #[ORM\Column]
    private ?int $company_catalog_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $discount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBillingId(): ?int
    {
        return $this->billing_id;
    }

    public function setBillingId(int $billing_id): static
    {
        $this->billing_id = $billing_id;

        return $this;
    }

    public function getCompanyCatalogId(): ?int
    {
        return $this->company_catalog_id;
    }

    public function setCompanyCatalogId(int $company_catalog_id): static
    {
        $this->company_catalog_id = $company_catalog_id;

        return $this;
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
}
