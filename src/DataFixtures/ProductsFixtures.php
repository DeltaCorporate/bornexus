<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Company;
use App\Entity\Supplier;
use App\Entity\Category;
use App\DataFixtures\CompaniesFixtures;
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

        $companies = $manager->getRepository(Company::class)->findAll();
        $categories = $manager->getRepository(Category::class)->findAll();
        $suppliers = $manager->getRepository(Supplier::class)->findAll();

        foreach ($companies as $company) {
            foreach ($categories as $category) {
                foreach ($suppliers as $supplier) {
                    for ($i = 0; $i < 3; $i++) {
                        $product = new Product();
                        $product->setName($faker->word);
                        $product->setDescription($faker->sentence);
                        $product->setPrice($faker->randomNumber(2));
                        $product->setPublished($faker->boolean);
                        $product->setStock($faker->randomNumber(2));
                        $product->setTva($faker->randomFloat(2, 0, 1));
                        $product->setCreatedAt(new \DateTimeImmutable());
                        $product->setUpdatedAt(new \DateTimeImmutable());
                        $product->setCategory($category);
                        $product->setCompany($company);
                        $product->setSupplier($supplier);
                        $manager->persist($product);
                    }
                }
            }
        }

        $manager->flush();
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
