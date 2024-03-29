<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use App\Entity\Company;
use App\Entity\CompanyCatalog;
use App\DataFixtures\ProductsFixtures;
use App\DataFixtures\CompaniesFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CompanyCatalogFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Supposons que vous ayez déjà des fixtures pour Company et Products
        $companies = $manager->getRepository(Company::class)->findAll();

        foreach ($companies as $company) {
            $products = $manager->getRepository(Product::class)->findAll();

            for ($j = 0; $j < 4; $j++) {
                $companyCatalog = new CompanyCatalog();
                $companyCatalog->setMargin($faker->randomFloat(2, 0, 100));
                $companyCatalog->setCompany($company);
                $companyCatalog->setStatus([true, false][rand(0, 1)]);
                $companyCatalog->setProduct($products[$j]);
                $companyCatalog->setCreatedAt(new \DateTime());
                $manager->persist($companyCatalog);
            }
           
        }

        $manager->flush();
        $manager->clear();
    }

    public function getDependencies()
    {
        return [
            CompaniesFixtures::class,
            ProductsFixtures::class,
        ];
    }
}
