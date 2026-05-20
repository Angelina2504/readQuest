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
                'birthday'=> $userDetails->getBirthday()?->format("Y-m-d"),
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
        $user->setUserAlias($data['alias']);
        $user->setEmail($data['email']);
        
    }else{
        $userDetails = new UserDetails();
        $userDetails->setBirthday(new \DateTime($data['birthday']));
        $userDetails->setGender($data['gender']);
        $user->setUserAlias($data['alias']);
        $user->setEmail($data['email']);
    }
     
    $userDetails->setUser($user);

    $this->entityManager->persist($userDetails);
    $this->entityManager->flush();

    return $this->json(['message' => 'UserDetails created successfully'], 201);
    }

    #[Route('/api/user/avatar', name: 'app_user_avatar', methods: ['POST'])]
    public function postAvatar(Request $request): JsonResponse
    {
        $user = $this->getUser();
        $file = $request->files->get('avatar');
        
        if (!$file) {
            return $this->json(['message' => 'No file provided'], 400);
        }

        if ($file->getSize() > 2 * 1024 * 1024) {
            return $this->json(['message' => 'File too large, max 2MB'], 400);
        }

        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->json(['message' => 'Invalid file type'], 400);
        }

        $userDetails = $user->getUserDetails();

        if (!$userDetails) {
            return $this->json(['message' => 'No UserDetails found'], 404);
        }

        $nomFichier = bin2hex(random_bytes(16)) . '.' . $file->getClientOriginalExtension();
        $file->move($this->getParameter('kernel.project_dir') . '/public/uploads/avatars/', $nomFichier);
        $userDetails->setAvatar('uploads/avatars/' . $nomFichier);

        $this->entityManager->persist($userDetails);
        $this->entityManager->flush();

        return $this->json(['message' => 'Avatar update']);
    }
}
