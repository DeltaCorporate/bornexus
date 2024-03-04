<?php

namespace App\DataFixtures;

use Exception;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Billing;
use App\Entity\Company;
use App\DataFixtures\UsersFixtures;
use App\DataFixtures\CompaniesFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BillingsFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Supposons que vous ayez déjà des fixtures pour Company et Users
        $companies = $manager->getRepository(Company::class)->findAll();

        foreach ($companies as $company) {
            // Récupérer tous les utilisateurs associés à l'entreprise
            $users = $manager->getRepository(User::class)->findBy(['company' => $company]);

            for ($i = 0; $i < 10; $i++) {
                if (isset($users[$i])) {
                    $billing = new Billing();
                    $billing->setStatus('unpaid');
                    $billing->setType($faker->randomElement(['invoice', 'quote']));
                    $billing->setEmitedAt(new \DateTimeImmutable($faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')));
                    $billing->setPaymentMethod($faker->randomElement(['stripe', 'deposit']));
                    $billing->setDiscount($faker->randomFloat(2, 0, 100));
                    $billing->setCreatedAt(new \DateTime());
                    $billing->setCompany($company);
                    $billing->setUsers($users[$i]);
                    $manager->persist($billing);
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
            UsersFixtures::class,
        ];
    }
}
