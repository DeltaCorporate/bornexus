<?php

namespace App\Entity;

use App\Repository\CompaniesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompaniesRepository::class)]
class Companies
{
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

    #[ORM\Column]
    private ?bool $tva = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tva_reason = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdÃ_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

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

    public function isTva(): ?bool
    {
        return $this->tva;
    }

    public function setTva(bool $tva): static
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

    public function getCreatedÃAt(): ?\DateTimeImmutable
    {
        return $this->createdÃ_at;
    }

    public function setCreatedÃAt(\DateTimeImmutable $createdÃ_at): static
    {
        $this->createdÃ_at = $createdÃ_at;

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
}
