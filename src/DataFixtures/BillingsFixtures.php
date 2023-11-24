<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Users;
use App\Entity\Billings;
use App\Entity\Companies;
use App\DataFixtures\UsersFixtures;
use App\DataFixtures\CompaniesFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BillingsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Supposons que vous ayez déjà des fixtures pour Company et Users
        $companies = $manager->getRepository(Companies::class)->findAll();

        foreach ($companies as $company) {
            // Récupérer tous les utilisateurs associés à l'entreprise
            $users = $manager->getRepository(Users::class)->findBy(['company' => $company]);

            for ($i = 0; $i < 4; $i++) {
                if (isset($users[$i])) {
                    $billing = new Billings();
                    $billing->setStatus($faker->randomElement(['paid', 'unpaid', 'pending']));
                    $billing->setType($faker->randomElement(['invoice', 'quote']));
                    $billing->setEmitedAt(new \DateTimeImmutable($faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')));
                    $billing->setPaymentMethod($faker->randomElement(['credit card', 'bank transfer', 'cash']));
                    $billing->setDiscount($faker->randomFloat(2, 0, 100));
                    $billing->setCompany($company);
                    $billing->setUsers($users[$i]);
                    $billing->setCreatedAt(new \DateTimeImmutable());
                    $billing->setUpdatedAt(new \DateTimeImmutable());
                    $manager->persist($billing);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CompaniesFixtures::class,
            UsersFixtures::class,
        ];
    }
}
