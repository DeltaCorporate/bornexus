<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProductsRepository::class)]
#[Uploadable()]
class Product
{
    use Timestampable;

    const TVA = [
        "20" =>'20%',
        "10" => '10%',
        "5.5" => '5.5%',
        "2.1" => "2.1%"
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?int $price = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: '2')]
    private ?string $tva = null;

    #[UploadableField(mapping: 'product_thumbnails', fileNameProperty: 'thumbnail')]
    #[Assert\Image(maxSize:10e6, mimeTypes: ['image/jpeg', 'image/png'], mimeTypesMessage: 'Please upload a valid image file')]
    private ?File $thumbnailFile = null;

    #[ORM\Column()]
    private ?string $thumbnail = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;



    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Supplier $supplier = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: CompanyCatalog::class)]
    private Collection $companyCatalogs;

    public function __construct()
    {
        $this->companyCatalogs = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getSupplier(): ?Supplier
    {
        return $this->supplier;
    }

    public function setSupplier(?Supplier $supplier): static
    {
        $this->supplier = $supplier;

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
            $companyCatalog->setProduct($this);
        }

        return $this;
    }

    public function removeCompanyCatalog(CompanyCatalog $companyCatalog): static
    {
        if ($this->companyCatalogs->removeElement($companyCatalog)) {
            // set the owning side to null (unless already changed)
            if ($companyCatalog->getProduct() === $this) {
                $companyCatalog->setProduct(null);
            }
        }

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail = null): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function setThumbnailFile(?File $thumbnailFile = null): Product
    {
        $this->thumbnailFile = $thumbnailFile;
        return $this;
    }

    public function getThumbnailFile(): ?File
    {
        return $this->thumbnailFile;
    }
}
