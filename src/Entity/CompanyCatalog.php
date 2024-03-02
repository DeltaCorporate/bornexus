<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\CompanyCatalogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyCatalogRepository::class)]
class CompanyCatalog
{
    use Timestampable;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'companyCatalogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'company_catalog', targetEntity: BillingCompanyCatalog::class)]
    private Collection $billingsCompanyCatalogs;

    #[ORM\ManyToOne(inversedBy: 'companyCatalogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(nullable: true)]
    private ?int $margin = null;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $status = null;

    public function __construct()
    {
        $this->billingsCompanyCatalogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductPriceWithMargin(): ?float
    {
        $productMargin = $this->getProduct()->getPrice() * ($this->getMargin() / 100);

        return $this->getProduct()->getPrice() + $productMargin;
    }
    

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, BillingCompanyCatalog>
     */
    public function getBillingsCompanyCatalogs(): Collection
    {
        return $this->billingsCompanyCatalogs;
    }

    public function addBillingsCompanyCatalog(BillingCompanyCatalog $billingsCompanyCatalog): static
    {
        if (!$this->billingsCompanyCatalogs->contains($billingsCompanyCatalog)) {
            $this->billingsCompanyCatalogs->add($billingsCompanyCatalog);
            $billingsCompanyCatalog->setCompanyCatalog($this);
        }

        return $this;
    }

    public function removeBillingsCompanyCatalog(BillingCompanyCatalog $billingsCompanyCatalog): static
    {
        if ($this->billingsCompanyCatalogs->removeElement($billingsCompanyCatalog)) {
            // set the owning side to null (unless already changed)
            if ($billingsCompanyCatalog->getCompanyCatalog() === $this) {
                $billingsCompanyCatalog->setCompanyCatalog(null);
            }
        }

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getMargin(): ?int
    {
        return $this->margin;
    }

    public function setMargin(?int $margin): static
    {
        $this->margin = $margin;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

}
