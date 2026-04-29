<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;

class RegistrationController extends AbstractController
{
    public function __construct(
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository
    ) {}

    #[Route('/api/auth/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        // Extract data from the JSON request body
        $data = json_decode($request->getContent(), true);
        
        
        
        if (empty($data['email']) || empty($data['password']) || empty($data['user_alias'])){
            return $this->json(['message' => 'Missing required fields'], 400);
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->json(['message' => 'Invalid email format'], 400);
            }

        if ($existingUser = $this->userRepository->findOneBy(['email'=>$data['email']])){
             return $this->json(['message' => 'Email already in use'], 409);
            } 
            
        if ($existingUser = $this->userRepository->findOneBy(['user_alias'=>$data['user_alias']])){
             return $this->json(['message' => 'Identifiant already in use'], 409);
            } 

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
    }}
