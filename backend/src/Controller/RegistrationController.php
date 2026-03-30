<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $entityManager
    ) {}

    #[Route('/api/auth/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        // Extract data from the JSON request body
        $data = json_decode($request->getContent(), true);

        // Create a new User instance
        $user = new User();
        $user->setEmail($data['email']);
        $user->setUserAlias($data['user_alias']);
        $user->setRoles(['ROLE_USER']);

        // Hash the password before storing it
        $hashedPassword = $this->hasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Persist and save the user in the database
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'User created successfully'], 201);
    }
}
