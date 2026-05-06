<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setUserAlias('Toto');
        
        $password = $this->hasher->hashPassword($user, 'password1234');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);

        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setUserAlias('Admin');
        
        $password = $this->hasher->hashPassword($user, 'password1234');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();
    }
}
