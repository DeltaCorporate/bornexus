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
    #[ORM\JoinColumn(nullable: true)]
    private ?CompanyCatalog $company_catalog = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(nullable: true)]
    private ?int $tva = null;

    #[ORM\Column(nullable: true)]
    private ?float $price_ht = null;

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
        $this->setPriceHt($this->getCompanyCatalog()->getProduct()->getPrice());
        $this->setTva($this->getCompanyCatalog()->getProduct()->getTva());

        return $this;
    }

    public function getPriceTtc(): ?float
    {
        return ($this->getDiscountedPriceHt() + $this->getPriceVat());
    }
    
    public function getPriceVat(): ?float
    {
        $tva = ($this->getTva()/100);
        return $this->getDiscountedPriceHt() * $tva;
    }

    public function getDiscountedPriceHt(): ?float
    {
        return $this->getPriceHt() - $this->getPriceDiscount();
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
        return $this->price_ht * $this->getQuantity();
    }
    /**
     * Vérifie si le BillingForm a un CompanyCatalog qui contient un Product.
     *
     * @return bool
     */
    public function hasCompanyCatalog(): bool
    {
        $companyCatalog = $this->getCompanyCatalog();
        return $this->getCompanyCatalog() !== null;
    }

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(?int $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function setPriceHt(?float $price_ht): static
    {
        $this->price_ht = $price_ht;

        return $this;
    }

}
