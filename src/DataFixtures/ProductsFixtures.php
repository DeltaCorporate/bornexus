<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\Category;
use App\DataFixtures\SuppliersFixtures;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\CategoriesFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); // Utilisez 'fr_FR' pour les données en français

        $categories = $manager->getRepository(Category::class)->findAll();
        $suppliers = $manager->getRepository(Supplier::class)->findAll();

            foreach ($categories as $category) {
                foreach ($suppliers as $supplier) {
                    for ($i = 0; $i < 4; $i++) {
                        $product = new Product();
                        $product->setName($faker->word);
                        $product->setDescription($faker->sentence);
                        $product->setPrice($faker->randomNumber(2));
                        $product->setPublished($faker->boolean);
                        $product->setStock($faker->randomNumber(2));
                        $product->setTva(['5', '10', '20'][rand(0, 2)]);
                        $product->setCategory($category);
                        $product->setSupplier($supplier);
                        $product->setThumbnail("https://cdn.futura-sciences.com/sources/images/dossier/773/01-intro-773.jpg");
                        $manager->persist($product);
                    }
                }
            }

        $manager->flush();
        $manager->clear();
    }

    public function getDependencies()
    {
        return [
            CompaniesFixtures::class,
            CategoriesFixtures::class,
            SuppliersFixtures::class,
        ];
    }
}
