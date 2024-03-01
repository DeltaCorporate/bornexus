<?php

namespace App\Twig\Components\Product;

use AllowDynamicProperties;
use App\Entity\CompanyCatalog;
use App\Entity\User;
use App\Repository\CompanyCatalogRepository;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AllowDynamicProperties] #[AsLiveComponent]
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

    // A compléter !
    /**
     * @throws ORMException
     */
    #[LiveAction]
    public function favoriteProduct(CompanyCatalogRepository $companyCatalog): void
    {
        $currentFavorites = new ArrayCollection();
        $this->currentFavorites = $this->favProducts;
        foreach ($currentFavorites as $productId) {
            $productId = $this->$companyCatalog->find($productId);

            if ($productId && !$currentFavorites->contains($productId)) {
                $companyCatalog->addFavoriteProduct($productId);
            }
            else {
                $companyCatalog->removeFavoriteProduct($productId);
            }

        }

        $this->favProducts = $companyCatalog->getFavoriteProducts($companyCatalog)->map(fn ($product) => $productId->getId())->toArray();
    }
}