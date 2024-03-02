<?php

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

class UserService
{
    public function filterRole(PersistentCollection|ArrayCollection $users, array|string $roles){

        return $users->filter(function($user) use ($roles) {
            if(is_string($roles))
                return in_array($roles, $user->getRoles());

            foreach ($roles as $role) {
                if (in_array($role, $user->getRoles()))
                    return true;
            }
            return false;
        });
    }
}