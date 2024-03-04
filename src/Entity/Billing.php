<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\BillingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

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

    #[ORM\ManyToOne(inversedBy: 'billings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'billing', targetEntity: BillingCompanyCatalog::class,cascade: ['persist'])]
    private Collection $billingsCompanyCatalogs;

    #[ORM\ManyToOne(inversedBy: 'billings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;
    
    private float $priceVat = 0;

    private float $priceDiscountOfLines = 0;

    private float $priceHt = 0;
    private float $priceTtc = 0;

    #[ORM\Column(nullable: true)]
    private ?int $discount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 3, nullable: true)]
    private ?string $amount_paid = null;

    #[ORM\Column(length: 400, nullable: true)]
    private ?string $checkout_session = null;

    #[ORM\Column(type: Types::GUID)]
    private ?string $uuid = null;
    
     const STATUS_LABEL = [
        'paid' => 'Payée',
        'unpaid' => 'Non payée',
         '' => ''
    ];

    const PAYMENT_METHOD = [
        'stripe' => 'Stripe',
        'deposit' => 'Virement'
    ];
    const TYPE = [
        'quote' => 'Devis',
        'invoice' => 'Facture'
    ];
    public function __construct()
    {
        $this->setUuid(Uuid::v4());
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
        if($payment_method != 'stripe')
            $this->setCheckoutSession(null);

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
        return static::round($this->priceTtc);
    }


    public function getPriceTtcDiscounted(): float
    {
        return $this->getPriceTtc() - $this->getDiscountPrice();
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
        return static::round($this->priceHt);
    }

    public function getDiscountPrice(): float
    {
        return static::round($this->getDiscount()/100 * $this->getPriceTtc());
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

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(?int $discount): static
    {
        $this->discount = $discount;

        return $this;
    }
    public function __clone()
    {
        if ($this->id) {
            $this->id = null;

            $clonedBillingsCompanyCatalogs = new ArrayCollection();
            foreach ($this->billingsCompanyCatalogs as $billingsCompanyCatalog) {
                $clonedBillingsCompanyCatalog = clone $billingsCompanyCatalog;
                $clonedBillingsCompanyCatalog->setBilling($this); // Associez le catalogue cloné à la nouvelle facture
                $clonedBillingsCompanyCatalogs->add($clonedBillingsCompanyCatalog);
            }
            $this->billingsCompanyCatalogs = $clonedBillingsCompanyCatalogs;
        }
    }

    public function getAmountPaid(): ?string
    {
        return $this->amount_paid;
    }


    public function setAmountPaid(?string $amount_paid): static
    {
        $this->amount_paid = $amount_paid;
        return $this;
    }


    public function getCheckoutSession(): ?string
    {
        return $this->checkout_session;
    }

    public function setCheckoutSession(?string $checkout_session): static
    {
        $this->checkout_session = $checkout_session;

        return $this;
    }

    public static function round($price){
        return round($price,2);
    }

    public function getBillingToken(): string{
        return $this->getUuid() ."_". $this->getId();
    }
    public static function extractToken(string $token): array{
        $token = explode("_",$token);
        return [
            'id' => $token[1] ?? null,
            'uuid' => $token[0] ?? null
        ];
    }
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }
}
