<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\BillingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: BillingsRepository::class)]
class Billing
{
    use Timestampable;
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

    #[ORM\ManyToOne(inversedBy: 'billings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'billing', targetEntity: BillingCompanyCatalog::class)]
    private Collection $billingsCompanyCatalogs;

    #[ORM\ManyToOne(inversedBy: 'billings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;
    
    private float $priceVat = 0;

    private float $priceDiscountOfLines = 0;

    private float $priceHt = 0;
    private float $priceTtc = 0;

     const STATUS_LABEL = [
        'paid' => 'Payée',
        'unpaid' => 'Non payée',
        'pending' => 'En cours'
    ];

    const PAYMENT_METHOD = [
        'stripe' => 'Stripe',
        'credit_card' => 'Carte de crédit',
        'paypal' => 'Paypal'
    ];
    const TYPE = [
        'quote' => 'Devis',
        'invoice' => 'Facture'
    ];
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
            if(!$billingCompanyCatalog->hasCompanyCatalog())
                    continue;
            $this->priceVat += $billingCompanyCatalog->getPriceVat();
            $this->priceDiscountOfLines += $billingCompanyCatalog->getPriceDiscount();
            $this->priceHt += $billingCompanyCatalog->getPriceHt();
            $this->priceTtc += $billingCompanyCatalog->getPriceTtc();
        }   
        return $this;
    }


    /**
     * Get the value of priceVat
     */ 
    public function getPriceVat(): float
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
    public function getPriceDiscountOfLines(): float
    {
        return $this->priceDiscountOfLines;
    }

    /**
     * Set the value of priceDiscount
     *
     * @return  self
     */ 
    public function setPriceDiscount(float $priceDiscountOfLines)
    {
        $this->priceDiscountOfLines = $priceDiscountOfLines;

        return $this;
    }

    /**
     * Get the value of priceTtc
     */ 
    public function getPriceTtc(): float
    {
        return $this->priceTtc;
    }


    public function getPriceTtcDiscounted(): float
    {
        $discount = $this->getDiscount()/100 * $this->getPriceTtc();
        return $this->getPriceTtc() - $discount;
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

      /**
     * Get the value of priceTtc
     */ 
    public function getPriceHt(): float
    {
        return $this->priceHt;
    }

    /**
     * Set the value of priceTtc
     *
     * @return  self
     */ 
    public function setPriceHt($priceHt)
    {
        $this->priceHt = $priceHt;

        return $this;
    }

    public function getStatusLabel(): string
    {
        return self::STATUS_LABEL[$this->getStatus()];
    }

    public function getTypeFirstLetter(): string
    {
        return strtoupper($this->getType()[0]);
    }
}
