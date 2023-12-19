<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Company;
use App\DataFixtures\CompaniesFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        // Get all companies
        $companies = $manager->getRepository(Company::class)->findAll();

        foreach ($companies as $company) {
            for ($i = 0; $i < 4; $i++) {
                $user = new User();
                $user->setEmail($faker->email);
                $user->setRoles(['ROLE_USER']);
                $user->setPassword($this->passwordHasher->hashPassword(
                    $user,
                    'the_new_password'
                ));
                $user->setFirstname($faker->firstName);
                $user->setLastname($faker->lastName);
                $user->setAddress($faker->address);
                $user->setCountry($faker->countryCode);
                $user->setZip(rand(10000, 99999));
                $user->setVerificationToken($faker->md5);
                $user->setVerifiedAt(new \DateTimeImmutable());
                $user->setCreatedAt(new \DateTimeImmutable());
                $user->setUpdatedAt(new \DateTimeImmutable());
                $user->setCompany($company); // Set the company of the user

                $manager->persist($user);
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