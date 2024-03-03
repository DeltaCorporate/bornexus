<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Common\Collections\Criteria;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findByCompanyAndRole(Company $company, array|string $roles,int $limit = null, int $offset = null): ArrayCollection
    {
        if (is_string($roles))
            $roles = [$roles];


        $qb = $this->createQueryBuilder('u')
                    ->where('u.company = :company')
                    ->setParameter('company', $company);

        $orX = $qb->expr()->orX();
        foreach ($roles as $index => $role) {
                $paramName = ':role' . $index;
                $orX->add($qb->expr()->like('u.roles', $paramName));
                $qb->setParameter($paramName, '%"'.$role.'"%');
        }
        $qb->andWhere($orX);
        if ($limit)
            $qb->setMaxResults($limit);
        if ($offset)
            $qb->setFirstResult($offset);

        return new ArrayCollection($qb->getQuery()->getResult());
    }
    public function remove(User $user)
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }
}
