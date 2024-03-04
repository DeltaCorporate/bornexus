<?php

namespace App\Twig\Components\Product;

use App\Entity\CompanyCatalog;
use App\Repository\CompanyCatalogRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ProductList
{
    use DefaultActionTrait;

    #[LiveProp(hydrateWith: 'hydrate',dehydrateWith: 'dehydrate')]
    public array $products = [];
    public int $totalProducts = 0;

    #[LiveProp]
    public int $currentPage = 1;

    public int $itemsPerPage = 8;

    public int $totalPages = 0;

    #[LiveProp]
    public array $companyCatalogProducts = [];


    public function __construct(
        private readonly ProductsRepository       $productsRepository,
        private readonly CompanyCatalogRepository $companyCatalogRepository,
        private readonly Security                 $security,
        private readonly EntityManagerInterface   $entityManager
    )
    {
        $this->products = $this->getProducts();
        $this->totalProducts = $productsRepository->count([]);
        $this->totalPages = $this->getTotalPages();
        $this->getCompanyCatalogData();
    }

    #[LiveAction]
    public function toggleFavorite(#[LiveArg] int $product): void
    {
        $productInDb = $this->productsRepository->find($product);
        //find if the product is already in the user's favorite
        $user = $this->security->getUser();
        $companyCatalog = $this->companyCatalogRepository->findOneBy(['company' => $user->getCompany(), 'product' => $productInDb]);
        if ($companyCatalog) {
            $companyCatalog->setStatus(!$companyCatalog->isStatus());
            $this->entityManager->persist($companyCatalog);
            $this->entityManager->flush();
        } else {
            $companyCatalog = new CompanyCatalog();
            $companyCatalog->setCompany($user->getCompany());
            $companyCatalog->setProduct($productInDb);
            $companyCatalog->setStatus(true);
            $companyCatalog->setMargin("0.3");
            $this->entityManager->persist($companyCatalog);
            $this->entityManager->flush();
        }
        $this->getCompanyCatalogData();
    }

    private function getCompanyCatalogData(): void
    {
        $user = $this->security->getUser();
        //filter by companyCatalog with status true
        $companyCatalog = $this->companyCatalogRepository->findBy(['company' => $user->getCompany(), 'status' => true]);
        //keep only the products id
        $this->companyCatalogProducts = array_map(function (CompanyCatalog $companyCatalog) {
            return $companyCatalog->getProduct()->getId();
        }, $companyCatalog);
    }

    public function getProducts(): array
    {
        $offset = ($this->currentPage - 1) * $this->itemsPerPage;
        $data =  $this->productsRepository->findBy([], null, $this->itemsPerPage, $offset);
        return $data;
    }

    private function getTotalPages(): int
    {
        return ceil($this->totalProducts / $this->itemsPerPage);
    }

    #[LiveAction]
    public function nextPage(): void
    {
        $this->currentPage++;
    }

    #[LiveAction]
    public function prevPage(): void
    {
        $this->currentPage--;
    }

    public function dehydrate(array $data): string
    {
        return serialize($data);
    }

    public function hydrate(string $data): array
    {
        $data = unserialize($data);
        return array_map(function ($product) {
            $supplier = $this->entityManager->find('App\Entity\Supplier', $product->getSupplier()->getId());
            $category = $this->entityManager->find('App\Entity\Category', $product->getCategory()->getId());
            $product->setSupplier($supplier);
            $product->setCategory($category)  ;
            return $product;
        }, $data);
    }
}