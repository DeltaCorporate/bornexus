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
        $this->products = $productsRepository->findAll();
        $this->totalProducts = $productsRepository->count([]);
    }
}