<?php

namespace App\Twig\Components\Product;

use App\Entity\User;
use App\Repository\ProductsRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ProductList
{
    use DefaultActionTrait;
    public array $products = [];
    public int $totalProducts = 0;

    #[LiveProp(writable: true)]
    public array $favProducts = [];

    public function __construct(ProductsRepository $productsRepository)
    {
        //find all products sorted by created_at
        $this->products = $productsRepository->findBy([], ['createdAt' => 'DESC']);
        $this->totalProducts = $productsRepository->count([]);
    }

    /*
     * Tableau en base de données (ancien tableau)
     * Tableau fait par le user (nouveau tableau)
     * Si dans ancien tableau mais pas dans le nouveau, on supprime
     * Si dans nouveau tableau mais pas dans l'ancien, on ajoute
     * Si dans les deux, on ne fait rien
     * */

    #[LiveAction]
    public function favoriteProduct(): void
    {
        dd($this->favProducts);
    }
}