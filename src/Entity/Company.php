<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\CompaniesRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use function PHPUnit\Framework\isEmpty;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: CompaniesRepository::class)]
class Company
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 14)]
    private ?string $siret = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $zip = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 60)]
    private ?string $country = null;

    #[ORM\Column(length:2048, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $paypal_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripe_id = null;

    #[ORM\Column(length: 34, nullable: true)]
    private ?string $iban = null;

    #[ORM\Column()]
    private ?float $tva = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tva_reason = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Supplier::class)]
    private Collection $suppliers;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Category::class)]
    private Collection $categories;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyCatalog::class)]
    private Collection $companyCatalogs;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Billing::class)]
    private Collection $billings;

    #[ORM\Column(length: 255)]
    private ?string $status = "active";

    const TVA = [
        "20" =>'20%',
        "10" => '10%',
        "5.5" => '5.5%',
        "2.1" => "2.1%"
    ];

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->companyCatalogs = new ArrayCollection();
        $this->billings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): static
    {
        $this->zip = $zip;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getPaypalId(): ?string
    {
        return $this->paypal_id;
    }

    public function setPaypalId(?string $paypal_id): static
    {
        $this->paypal_id = $paypal_id;

        return $this;
    }

    public function getStripeId(): ?string
    {
        return $this->stripe_id;
    }

    public function setStripeId(?string $stripe_id): static
    {
        $this->stripe_id = $stripe_id;

        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): static
    {
        $this->iban = $iban;

        return $this;
    }

    public function isTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getTvaReason(): ?string
    {
        return $this->tva_reason;
    }

    public function setTvaReason(?string $tva_reason): static
    {
        $this->tva_reason = $tva_reason;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setCompany($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCompany() === $this) {
                $user->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Supplier>
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Supplier $supplier): static
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers->add($supplier);
            $supplier->setCompany($this);
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): static
    {
        if ($this->suppliers->removeElement($supplier)) {
            // set the owning side to null (unless already changed)
            if ($supplier->getCompany() === $this) {
                $supplier->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setCompany($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCompany() === $this) {
                $category->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyCatalog>
     */
    public function getCompanyCatalogs(): Collection
    {
        return $this->companyCatalogs;
    }

    public function addCompanyCatalog(CompanyCatalog $companyCatalog): static
    {
        if (!$this->companyCatalogs->contains($companyCatalog)) {
            $this->companyCatalogs->add($companyCatalog);
            $companyCatalog->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyCatalog(CompanyCatalog $companyCatalog): static
    {
        if ($this->companyCatalogs->removeElement($companyCatalog)) {
            // set the owning side to null (unless already changed)
            if ($companyCatalog->getCompany() === $this) {
                $companyCatalog->setCompany(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, Billing>
     */
    public function getBillings(): Collection
    {
        return $this->billings;
    }

    public function addBilling(Billing $billing): static
    {
        if (!$this->billings->contains($billing)) {
            $this->billings->add($billing);
            $billing->setCompany($this);
        }

        return $this;
    }

    public function removeBilling(Billing $billing): static
    {
        if ($this->billings->removeElement($billing)) {
            // set the owning side to null (unless already changed)
            if ($billing->getCompany() === $this) {
                $billing->setCompany(null);
            }
        }

        return $this;
    }

    public function getCountClients(): int
    {
        return $this->getUsers()->count();
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

    public function getTest(): ?float
    {
        return $this->test;
    }

    public function setTest(float $test): static
    {
        $this->test = $test;

        return $this;
    }
}
