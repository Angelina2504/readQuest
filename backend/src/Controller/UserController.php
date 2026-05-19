<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\UserDetails;

final class UserController extends AbstractController
{

     public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}


    #[Route('/api/user/profile', name: 'app_user', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
         return $this->json(['message' => 'Not authenticated'], 401);
        };

        $userDetails = $user->getUserDetails();

        if ($userDetails) {
            return $this->json([
                'alias'=> $user->getUserAlias(),
                'email'=> $user->getEmail(),
                'birthday'=> $userDetails->getBirthday()->format("Y-m-d"),
                'gender'=> $userDetails->getGender(),
                'avatar'=> $userDetails->getAvatar(),
            ]);
        };

        if (!$userDetails) {
             return $this->json(['message' => 'non-existent profile'], 404);
        }
    }

    #[Route('/api/user/profile', name: 'app_user_update', methods: ['PATCH'])]
    public function createUserDetails(Request $request): JsonResponse
    {

    $data = json_decode($request->getContent(), true);

    $user = $this->getUser();

    if ($user->getUserDetails()){
        $userDetails = $user->getUserDetails();
        $userDetails->setBirthday(new \DateTime($data['birthday']));
        $userDetails->setGender($data['gender']);
        $userDetails->setAvatar($data['avatar']);
    }else{
        $userDetails = new UserDetails();
        $userDetails->setBirthday(new \DateTime($data['birthday']));
        $userDetails->setGender($data['gender']);
        $userDetails->setAvatar($data['avatar']);
    }
     
    $userDetails->setUser($user);

    $this->entityManager->persist($userDetails);
    $this->entityManager->flush();

    return $this->json(['message' => 'UserDetails created successfully'], 201);

    }
}
