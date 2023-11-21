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

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $discount = null;

    #[ORM\ManyToOne(inversedBy: 'billingsCompanyCatalogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Billings $billing = null;

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

    public function getBilling(): ?Billings
    {
        return $this->billing;
    }

    public function setBilling(?Billings $billing): static
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
