<?php

namespace App\DataFixtures;

use App\Entity\Quest;
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
        if (!$manager->getRepository(User::class)->findOneBy(['email' => 'test@example.com'])) {
            $user = new User();
            $user->setEmail('test@example.com');
            $user->setUserAlias('Toto');
            $password = $this->hasher->hashPassword($user, 'password1234');
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $manager->flush();
        }

        if (!$manager->getRepository(User::class)->findOneBy(['email' => 'admin@example.com'])) {
            $user = new User();
            $user->setEmail('admin@example.com');
            $user->setUserAlias('Admin');
            $password = $this->hasher->hashPassword($user, 'password1234');
            $user->setPassword($password);
            $user->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);
            $manager->flush();
        }

        if (!$manager->getRepository(Quest::class)->findOneBy(['quest_title' => 'Dévoreur de pages'])) {
            $quest = new Quest();
            $quest->setQuestTitle('Dévoreur de pages');
            $quest->setQuestBadge('lire3Livres.png');
            $quest->setQuestDescription('Tu as la lecture dans le sang ! Lis 3 livres pour décrocher ce badge.');
            $quest->setQuestRules('Marquer 3 livres comme "lu" après avoir rejoint la quête.');
            $quest->setQuestDifficulty('Débutant');
            $quest->setQuestCriteriaType('book_count');
            $quest->setQuestCriteriaValue(null);
            $quest->setQuestCriteriaTarget(3);
            $manager->persist($quest);
        }

        if (!$manager->getRepository(Quest::class)->findOneBy(['quest_title' => 'Amateur de fiction'])) {
            $quest2 = new Quest();
            $quest2->setQuestTitle('Amateur de fiction');
            $quest2->setQuestBadge('lire3Livres.png');
            $quest2->setQuestDescription('Laisse-toi emporter par l\'imaginaire ! Lis 3 livres de fiction pour décrocher ce badge.');
            $quest2->setQuestRules('Marquer 3 livres du genre "Fiction" comme "lu" après avoir rejoint la quête.');
            $quest2->setQuestDifficulty('Débutant');
            $quest2->setQuestCriteriaType('genre');
            $quest2->setQuestCriteriaValue('%Fiction%');
            $quest2->setQuestCriteriaTarget(3);
            $manager->persist($quest2);
        }

        $manager->flush();
    }
}
