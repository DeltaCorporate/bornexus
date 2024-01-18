<?php

namespace App\Entity;

use App\Repository\BillingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: BillingsRepository::class)]
class Billing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $status = null;

    #[ORM\Column(length: 25)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $emited_at = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $payment_method = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0', nullable: true)]
    private ?string $discount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'billings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'billing', targetEntity: BillingCompanyCatalog::class)]
    private Collection $billingsCompanyCatalogs;

    #[ORM\ManyToOne(inversedBy: 'billings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;
    
    private float $priceVat = 0;

    private float $priceDiscount = 0;

    private float $priceTtc = 0;
    public function __construct()
    {
        $this->billingsCompanyCatalogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getEmitedAt(): ?\DateTimeImmutable
    {
        return $this->emited_at;
    }

    public function setEmitedAt(\DateTimeImmutable $emited_at): static
    {
        $this->emited_at = $emited_at;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(?string $payment_method): static
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtAuto(): void {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtAuto(): void {
        $this->setUpdatedAt(new \DateTimeImmutable());
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
            $billingsCompanyCatalog->setBilling($this);
        }

        return $this;
    }

    public function removeBillingsCompanyCatalog(BillingCompanyCatalog $billingsCompanyCatalog): static
    {
        if ($this->billingsCompanyCatalogs->removeElement($billingsCompanyCatalog)) {
            // set the owning side to null (unless already changed)
            if ($billingsCompanyCatalog->getBilling() === $this) {
                $billingsCompanyCatalog->setBilling(null);
            }
        }

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): static
    {
        $this->users = $users;

        return $this;
    }
    

    public function calculTotalPrices(): Billing 
    {
        $billingsCompanyCatalogs = $this->getBillingsCompanyCatalogs();
        
        foreach($billingsCompanyCatalogs as $billingCompanyCatalog){
            $this->priceVat += $billingCompanyCatalog->getPriceVat();
            $this->priceDiscount += $billingCompanyCatalog->getPriceDiscount();
            $this->priceTtc += $billingCompanyCatalog->getPriceTtc();
        }   
        return $this;
    }


    /**
     * Get the value of priceVat
     */ 
    public function getPriceVat()
    {
        return $this->priceVat;
    }

    /**
     * Set the value of priceVat
     *
     * @return  self
     */ 
    public function setPriceVat($priceVat)
    {
        $this->priceVat = $priceVat;

        return $this;
    }

    /**
     * Get the value of priceDiscount
     */ 
    public function getPriceDiscount()
    {
        return $this->priceDiscount;
    }

    /**
     * Set the value of priceDiscount
     *
     * @return  self
     */ 
    public function setPriceDiscount($priceDiscount)
    {
        $this->priceDiscount = $priceDiscount;

        return $this;
    }

    /**
     * Get the value of priceTtc
     */ 
    public function getPriceTtc()
    {
        return $this->priceTtc;
    }

    /**
     * Set the value of priceTtc
     *
     * @return  self
     */ 
    public function setPriceTtc($priceTtc)
    {
        $this->priceTtc = $priceTtc;

        return $this;
    }
}
