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

        // Get all repository
        $repository = $manager->getRepository(Company::class);
        $superAdmin = new User();
        $superAdmin->setEmail('admin@test.com');
        $superAdmin->setRoles(['ROLE_SUPER_ADMIN']);
        $superAdmin->setPassword($this->passwordHasher->hashPassword(
            $superAdmin,
            'password'
        ));
        $superAdmin->setFirstname($faker->firstName);
        $superAdmin->setLastname($faker->lastName);
        $superAdmin->setAddress($faker->address);
        $superAdmin->setCountry($faker->countryCode);
        $superAdmin->setZip(rand(10000, 99999));
        $superAdmin->setVerificationToken($faker->md5);
        $superAdmin->setVerifiedAt(new \DateTimeImmutable());
        $superAdmin->setCreatedAt(new \DateTimeImmutable());
        $superAdmin->setUpdatedAt(new \DateTimeImmutable());
        $superAdmin->setCompany($repository->find(1));
        $manager->persist($superAdmin);
        foreach ($repository->findAll() as $company) {
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
                $user->setCompany($company);

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