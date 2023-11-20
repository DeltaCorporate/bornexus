<?php

namespace App\Entity;

use App\Repository\CompanyCatalogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyCatalogRepository::class)]
class CompanyCatalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $product_id = null;

    #[ORM\Column]
    private ?int $company_id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $margin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): static
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getCompanyId(): ?int
    {
        return $this->company_id;
    }

    public function setCompanyId(int $company_id): static
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function getMargin(): ?string
    {
        return $this->margin;
    }

    public function setMargin(string $margin): static
    {
        $this->margin = $margin;

        return $this;
    }
}
