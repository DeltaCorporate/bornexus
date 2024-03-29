<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Company;
use App\Entity\Supplier;
use App\DataFixtures\CompaniesFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SuppliersFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); // Utilisez 'fr_FR' pour les données en français
        $companies = $manager->getRepository(Company::class)->findAll();

        foreach ($companies as $company) {
            for ($i = 0; $i < 4; $i++) {
                $supplier = new Supplier();
                $supplier->setName($faker->company);
                $supplier->setWebsite($faker->url);
                $supplier->setCompany($company);
                $supplier->setCreatedAt(new \DateTime());
                $manager->persist($supplier);
            }
        }
        $manager->flush();
        $manager->clear();
    }

    public function getDependencies()
    {
        return [
            CompaniesFixtures::class,
        ];
    }
}
