<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\QuestRepository;
use App\Repository\ParticipationRepository;
use App\Entity\Participation;
use App\Entity\Quest;

final class QuestController extends AbstractController
{
    public function __construct(
    private ParticipationRepository $participationRepository,
    private EntityManagerInterface $entityManager,
    private QuestRepository $questRepository,
    ) {}

    #[Route('/api/quests', name: 'quest_available', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $quests = $this->questRepository->findAll();    
        $questStock= [];

        foreach ($quests as $quest) {
            $questStock[] = [
                'quest_id' => $quest->getId(),
                'quest_title' => $quest->getQuestTitle(),
                'quest_badge' => $quest->getQuestBadge(),
                'quest_description' => $quest->getQuestDescription(),
                'quest_rules' => $quest->getQuestRules(),
                'quest_difficulty' => $quest->getQuestDifficulty(),
                'quest_criteria_type' => $quest->getQuestCriteriaType(),
                'quest_criteria_value' => $quest->getQuestCriteriaValue(),
                'quest_criteria_target' => $quest->getQuestCriteriaTarget(),
            ];
        }
        return $this->json($questStock);
    }

    #[Route('/api/quests/{id}/join', name: 'quest_join', methods: ['POST'])]
    public function questJoin(Request $request, int $id): JsonResponse
    {
        $user = $this->getUser();

        if($user === null){
            return $this->json(['message' => 'Unauthorized'], 401);
        }

        $quest = $this->questRepository->findOneBy(['id'=>$id]);

        if($quest === null){
         return $this->json(['message' => 'Quest not found'], 404);
        }

        $existingParticipation = $this->participationRepository->findOneBy(['user' => $user, 'quest' => $quest]);

        if($existingParticipation !== null){
            return $this->json(['message' => 'Already joined'], 200);
        }

        $participation = new Participation();
        $participation->setParticipProgression(0);
        $participation->setParticipStatut('en_cours');
        $participation->setParticipStartDate(new \DateTime());
        $participation->setUser($user);
        $participation->setQuest($quest);

        $this->entityManager->persist($participation);
        $this->entityManager->flush();

         return $this->json(['message' => 'Quest joined successfully'], 201);

    }

    #[Route('/api/quests/my', name: 'quest_display', methods: ['GET'])]
    public function questDisplay(Request $request): JsonResponse
    {
        $user = $this->getUser();

        $participations = $this->participationRepository->findBy(['user' => $user]);

        $myquests = [];

        foreach ($participations as $participation) {
            $myquests[] = [
                'participation_id' => $participation->getId(),
                'particip_statut' => $participation->getParticipStatut(),
                'particip_progression' => $participation->getParticipProgression(),
                'particip_start_date' => $participation->getParticipStartDate()?->format('Y-m-d'),
                'quest_id' => $participation->getQuest()->getId(),
                'quest_title' => $participation->getQuest()->getQuestTitle(),
                'quest_badge' => $participation->getQuest()->getQuestBadge(),
                'quest_difficulty' => $participation->getQuest()->getQuestDifficulty(),
                'quest_criteria_type' => $participation->getQuest()->getQuestCriteriaType(),
                'quest_criteria_value' => $participation->getQuest()->getQuestCriteriaValue(),
                'quest_criteria_target' => $participation->getQuest()->getQuestCriteriaTarget(),
            ];
        }
        return $this->json($myquests);
    }

     #[Route('/api/quests/{id}/leave', name: 'quest_delete', methods: ['DELETE'])]
    public function questDelete(int $id): JsonResponse
    {
        $user = $this->getUser();

        $quest = $this->questRepository->findOneBy(['id' => $id]);

        $participation = $this->participationRepository->findOneBy(['user' => $user, 'quest' => $quest]);

        if($participation === null){
            return $this->json(['message' => 'Quest not found'], 404);
        }

        $this->entityManager->remove($participation);

        $this->entityManager->flush();

        return $this->json(['message' => 'Quest Delete'], 200);
    }

}