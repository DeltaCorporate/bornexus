<?php

namespace App\Entity;

use App\Repository\CompanyCatalogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyCatalogRepository::class)]
class CompanyCatalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $margin = null;

    #[ORM\ManyToOne(inversedBy: 'companyCatalogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Companies $company = null;

    #[ORM\OneToMany(mappedBy: 'company_catalog', targetEntity: BillingsCompanyCatalog::class)]
    private Collection $billingsCompanyCatalogs;

    #[ORM\ManyToOne(inversedBy: 'companyCatalogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Products $product = null;

    public function __construct()
    {
        $this->billingsCompanyCatalogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCompany(): ?Companies
    {
        return $this->company;
    }

    public function setCompany(?Companies $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, BillingsCompanyCatalog>
     */
    public function getBillingsCompanyCatalogs(): Collection
    {
        return $this->billingsCompanyCatalogs;
    }

    public function addBillingsCompanyCatalog(BillingsCompanyCatalog $billingsCompanyCatalog): static
    {
        if (!$this->billingsCompanyCatalogs->contains($billingsCompanyCatalog)) {
            $this->billingsCompanyCatalogs->add($billingsCompanyCatalog);
            $billingsCompanyCatalog->setCompanyCatalog($this);
        }

        return $this;
    }

    public function removeBillingsCompanyCatalog(BillingsCompanyCatalog $billingsCompanyCatalog): static
    {
        if ($this->billingsCompanyCatalogs->removeElement($billingsCompanyCatalog)) {
            // set the owning side to null (unless already changed)
            if ($billingsCompanyCatalog->getCompanyCatalog() === $this) {
                $billingsCompanyCatalog->setCompanyCatalog(null);
            }
        }

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): static
    {
        $this->product = $product;

        return $this;
    }

}
