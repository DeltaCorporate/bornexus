<?php

namespace App\Twig\Components\Product;

use App\Repository\ProductsRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ProductList
{
    use DefaultActionTrait;
    public array $products = [];
    public int $totalProducts = 0;

    public function __construct(ProductsRepository $productsRepository)
    {
        //find all products sorted by created_at
        $this->products = $productsRepository->findBy([], ['createdAt' => 'DESC']);
        $this->totalProducts = $productsRepository->count([]);
    }
}