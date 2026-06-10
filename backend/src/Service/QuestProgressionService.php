<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParticipationRepository;
use App\Repository\ReadingRepository;
use App\Service\ActivityLogService;

class QuestProgressionService
{
    public function __construct(

    private EntityManagerInterface $entityManager,
    private ParticipationRepository $participationRepository,
    private ReadingRepository $readingRepository,
    private ActivityLogService $activityLogService,
    ) {}

    public function updateProgression($user): void
    {
        $participations = $this->participationRepository->findBy(['user' => $user, 'particip_statut' => 'en_cours']);

        foreach ($participations as $participation) {
            $quest = $participation->getQuest();
            $startDate = $participation->getParticipStartDate();
            $criteriaType = $quest->getQuestCriteriaType();
            $criteriaValue = $quest->getQuestCriteriaValue();
            $target = $quest->getQuestCriteriaTarget();

             if($startDate === null) {
                    continue;}

            $progression = 0;

            switch ($criteriaType) {
                case 'book_count':
                    $progression = $this->readingRepository->countReadBooksAfterDate($user, $startDate);
                   
                break;
                case 'genre':
                    $progression = $this->readingRepository->countReadBooksByGenreAfterDate($user, $startDate,$criteriaValue );
                break;
                case 'author':
                    $progression = $this->readingRepository->countReadBooksByAuthorAfterDate($user, $startDate,$criteriaValue );
                break;
            }

            $participation->setParticipProgression($progression);

            if($progression >= $target) {
                $participation->setParticipStatut('completee');
            }
            
            $action = ($progression >= $target) ? 'quest_completed' : 'quest_progressed';
            $this->activityLogService->log($user->getId(), $action, $quest->getQuestTitle());


  
        }
            $this->entityManager->flush();

           
    }
}