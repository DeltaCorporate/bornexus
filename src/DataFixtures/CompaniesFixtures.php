<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompaniesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR'); // Utilisez 'fr_FR' pour les données en français
        for ($i = 0; $i < 4; $i++) {
            $company = new Company();
            $company->setName($faker->company);
            $company->setDescription($faker->text);
            $company->setSiret(str_replace(' ','',$faker->siret));
            $company->setZip(rand(10000, 99999));
            $company->setAddress($faker->address);
            $company->setCountry($faker->country);
            $company->setWebsite($faker->url);
            $company->setPaypalId($faker->uuid);
            $company->setStripeId($faker->uuid);
            $company->setIban($faker->iban('FR'));
            //random TVA based on Company::TVA it's string convert it to float
            $company->setTva((float) $faker->randomElement(Company::TVA));
            $company->setTvaReason($faker->sentence);
            $company->setCreatedAt(new \DateTime());
            $company->setUpdatedAt(new \DateTime());
            $company->setStatus($faker->randomElement(['pending', 'active', 'inactive']));
            $manager->persist($company);
        }
        $manager->flush();
        $manager->clear();
    }
}