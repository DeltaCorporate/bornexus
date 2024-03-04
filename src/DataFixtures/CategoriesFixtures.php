<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\Company;
use App\Entity\Category;
use App\DataFixtures\CompaniesFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); // Utilisez 'fr_FR' pour les données en français
        $companies = $manager->getRepository(Company::class)->findAll();
        foreach ($companies as $company) {
            for ($i = 0; $i < 4; $i++) {
                $category = new Category();
                $category->setName($faker->word);
                $category->setDescription($faker->sentence);
                $category->setCompany($company);
                $category->setCreatedAt(new \DateTime());
                $manager->persist($category);
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
