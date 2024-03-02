<?php

namespace App\Twig\Components\Product;

use AllowDynamicProperties;
use App\Entity\CompanyCatalog;
use App\Entity\User;
use App\Repository\CompanyCatalogRepository;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
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

    public array $products = [];
    public int $totalProducts = 0;

    #[LiveProp]
    public array $companyCatalogProducts = [];


    public function __construct(
        private readonly ProductsRepository       $productsRepository,
        private readonly CompanyCatalogRepository $companyCatalogRepository,
        private readonly Security                 $security,
        private readonly EntityManagerInterface $entityManager
    )
    {
        //find all products sorted by created_at
        $this->products = $productsRepository->findBy([], ['createdAt' => 'DESC']);
        $this->totalProducts = $productsRepository->count([]);
        $this->getCompanyCatalogData();
    }

    #[LiveAction]
    public function toggleFavorite(#[LiveArg] int $product): void
    {
        $productInDb = $this->productsRepository->find($product);
        //find if the product is already in the user's favorite
        $user = $this->security->getUser();
        $companyCatalog = $this->companyCatalogRepository->findOneBy(['company' => $user->getCompany(), 'product' => $productInDb]);
        if ($companyCatalog){
            $companyCatalog->setStatus(!$companyCatalog->isStatus());
            $this->entityManager->persist($companyCatalog);
            $this->entityManager->flush();
        } else{
            $companyCatalog = new CompanyCatalog();
            $companyCatalog->setCompany($user->getCompany());
            $companyCatalog->setProduct($productInDb);
            $companyCatalog->setStatus(true);
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
}