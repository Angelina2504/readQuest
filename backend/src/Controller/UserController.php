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
             return $this->json([
                'alias'    => $user->getUserAlias(),
                'email'    => $user->getEmail(),
                'birthday' => null,
                'gender'   => null,
                'avatar'   => null,
             ], 200);
        }
    }

    #[Route('/api/user/profile', name: 'app_user_update', methods: ['PATCH'])]
    public function createUserDetails(Request $request): JsonResponse
    {

    $data = json_decode($request->getContent(), true);

    if ($data === null) {
        return $this->json(['message' => 'Invalid JSON'], 400);
    }

    $user = $this->getUser();

    $birthday = isset($data['birthday']) ? new \DateTime($data['birthday']) : null;

    if ($user->getUserDetails()){
        $userDetails = $user->getUserDetails();
        $userDetails->setBirthday($birthday);
        $userDetails->setGender($data['gender'] ?? null);
        $user->setUserAlias($data['alias'] ?? $user->getUserAlias());
        $user->setEmail($data['email'] ?? $user->getEmail());

    }else{
        $userDetails = new UserDetails();
        $userDetails->setBirthday($birthday);
        $userDetails->setGender($data['gender'] ?? null);
        $user->setUserAlias($data['alias'] ?? $user->getUserAlias());
        $user->setEmail($data['email'] ?? $user->getEmail());
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
             $userDetails = new UserDetails();
             $userDetails->setUser($user);
             $this->entityManager->persist($userDetails);
        }

        $oldAvatar = $userDetails->getAvatar();
        if ($oldAvatar) {
            $oldPath = $this->getParameter('kernel.project_dir') . '/public/' . $oldAvatar;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $nomFichier = bin2hex(random_bytes(16)) . '.' . ($file->guessExtension() ?? 'bin');
        $file->move($this->getParameter('kernel.project_dir') . '/public/uploads/avatars/', $nomFichier);
        $userDetails->setAvatar('uploads/avatars/' . $nomFichier);

        $this->entityManager->persist($userDetails);
        $this->entityManager->flush();

        return $this->json(['message' => 'Avatar update']);
    }
}
