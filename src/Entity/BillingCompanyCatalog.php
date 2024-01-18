<?php

namespace App\Entity;

use App\Repository\BillingsCompanyCatalogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillingsCompanyCatalogRepository::class)]
class BillingCompanyCatalog
{
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

    #[ORM\Column]
    private ?int $quantity = null;


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

    public function getPriceTtc(): ?float
    {
        $price = $this->getPriceHt() - $this->getPriceDiscount();

        return ($price - $this->getPriceVat());
    }
    
    public function getPriceVat(): ?float
    {
        $price = $this->getPriceHt() - $this->getPriceDiscount();

        $tva = $this->getCompanyCatalog()->getProduct()->getTva();
        return $price * $tva;
    }

    public function getPriceDiscount(): ?float
    {
        return $this->getDiscount() * $this->getPriceHt();
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
    public function getPriceHt(): float
    {
        $price = $this->getCompanyCatalog()->getProduct()->getPrice();
        return $price * $this->getQuantity();
    }

}
