<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
        // hasher de mot de passe
        private $hasher;
        public function __construct(UserPasswordHasherInterface $hasher)
        {
            $this->hasher = $hasher;
        }
    public function load(ObjectManager $manager): void
    {
        // appelle entity User
        $admin = new User();
        $admin->setEmail("admin@yahoo.fr")
              ->setNom("BIGOUNDOU")
              ->setPrenom("Terry")
              ->setPassword($this->hasher->hashPassword($admin,"azerty"))
              ->setRoles(["ROLE_ADMIN"]);
        //commit admin
        $manager->persist($admin);
        // utilisateur test
        $user = new User();
        $user->setEmail("bill@yahoo.fr")
              ->setNom("BOQUET")
              ->setPrenom("BILL")
              ->setPassword($this->hasher->hashPassword($user,"azerty"))
              ->setRoles(["ROLE_USER"]);
        //commit user
        $manager->persist($user);





        //push admin
        $manager->flush();
    }
}
