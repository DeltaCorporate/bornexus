<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use App\Entity\Companies;
use App\Entity\Categories;
use App\DataFixtures\CompaniesFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); // Utilisez 'fr_FR' pour les données en français
        $companies = $manager->getRepository(Companies::class)->findAll();
        foreach ($companies as $company) {
            for ($i = 0; $i < 10; $i++) {
                $category = new Categories();
                $category->setName($faker->word);
                $category->setDescription($faker->sentence);
                $category->setCompany($company);

                $manager->persist($category);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompaniesFixtures::class,
        ];
    }
}
