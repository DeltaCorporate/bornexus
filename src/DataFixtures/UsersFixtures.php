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
        $companies = $repository->findAll();
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
        $superAdmin->setCreatedAt(new \DateTime());
        $superAdmin->setUpdatedAt(new \DateTime());
        $superAdmin->setCompany($companies[0]);
        $manager->persist($superAdmin);
        $admin = new User();
        $admin->setEmail('admin_simple@test.com');
        $admin->setRoles(['ROLE_ADMIN_COMPANY']);
        $admin->setPassword($this->passwordHasher->hashPassword(
            $admin,
            'password'
        ));
        $admin->setFirstname($faker->firstName);
        $admin->setLastname($faker->lastName);
        $admin->setAddress($faker->address);
        $admin->setCountry($faker->countryCode);
        $admin->setZip(rand(10000, 99999));
        $admin->setVerificationToken($faker->md5);
        $admin->setVerifiedAt(new \DateTimeImmutable());
        $admin->setCreatedAt(new \DateTime());
        $admin->setUpdatedAt(new \DateTime());
        $admin->setCompany($companies[0]);
        $manager->persist($admin);
        $commercial = new User();
        $commercial->setEmail('commercial@test.com');
        $commercial->setRoles(['ROLE_COMMERCIAL_COMPANY']);
        $commercial->setPassword($this->passwordHasher->hashPassword(
            $commercial,
            'password'
        ));
        $commercial->setFirstname($faker->firstName);
        $commercial->setLastname($faker->lastName);
        $commercial->setAddress($faker->address);
        $commercial->setCountry($faker->countryCode);
        $commercial->setZip(rand(10000, 99999));
        $commercial->setVerificationToken($faker->md5);
        $commercial->setVerifiedAt(new \DateTimeImmutable());
        $commercial->setCreatedAt(new \DateTime());
        $commercial->setUpdatedAt(new \DateTime());
        $commercial->setCompany($companies[0]);
        $manager->persist($commercial);
        $comptable = new User();
        $comptable->setEmail('commptable@test.com');
        $comptable->setRoles(['ROLE_ACCOUNTANT_COMPANY']);
        $comptable->setPassword($this->passwordHasher->hashPassword(
            $comptable,
            'password'
        ));
        $comptable->setFirstname($faker->firstName);
        $comptable->setLastname($faker->lastName);
        $comptable->setAddress($faker->address);
        $comptable->setCountry($faker->countryCode);
        $comptable->setZip(rand(10000, 99999));
        $comptable->setVerificationToken($faker->md5);
        $comptable->setVerifiedAt(new \DateTimeImmutable());
        $comptable->setCreatedAt(new \DateTime());
        $comptable->setUpdatedAt(new \DateTime());
        $comptable->setCompany($companies[0]);
        $manager->persist($comptable);
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
                $user->setCreatedAt(new \DateTime());
                $user->setUpdatedAt(new \DateTime());
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