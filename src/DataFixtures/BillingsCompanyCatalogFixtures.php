<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Billings;
use App\Entity\Companies;
use App\Entity\CompanyCatalog;
use App\DataFixtures\BillingsFixtures;
use App\Entity\BillingsCompanyCatalog;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\CompanyCatalogFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BillingsCompanyCatalogFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Supposons que vous ayez déjà des fixtures pour Company et Users
        $companies = $manager->getRepository(Companies::class)->findAll();
        $billings = $manager->getRepository(Billings::class)->findAll();

        foreach ($companies as $company) {
            $companyCatalogs = $manager->getRepository(CompanyCatalog::class)->findBy(['company' => $company]);
            foreach($companyCatalogs as $companyCatalog){
                $billingsCompanyCatalog = new BillingsCompanyCatalog(); 
                $billingsCompanyCatalog->setDiscount($faker->randomFloat(2, 0, 1)); // Génère un float aléatoire entre 0 et 1 avec une précision de 2 chiffres après la virgule
                $billingsCompanyCatalog->setBilling($faker->randomElement($billings)); // Sélectionne un élément aléatoire dans le tableau des Billings
                $billingsCompanyCatalog->setCompanyCatalog($companyCatalog);
                $manager->persist($billingsCompanyCatalog);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompanyCatalogFixtures::class,
            BillingsFixtures::class,
        ];
    }
}