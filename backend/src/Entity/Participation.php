<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $particip_progression = null;

    #[ORM\Column(length: 30)]
    private ?string $particip_statut = null;

    #[ORM\ManyToOne(inversedBy: 'participations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'participations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quest $quest = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $particip_start_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParticipProgression(): ?int
    {
        return $this->particip_progression;
    }

    public function setParticipProgression(int $particip_progression): static
    {
        $this->particip_progression = $particip_progression;

        return $this;
    }

    public function getParticipStatut(): ?string
    {
        return $this->particip_statut;
    }

    public function setParticipStatut(string $particip_statut): static
    {
        $this->particip_statut = $particip_statut;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getQuest(): ?Quest
    {
        return $this->quest;
    }

    public function setQuest(?Quest $quest): static
    {
        $this->quest = $quest;

        return $this;
    }

    public function getParticipStartDate(): ?\DateTime
    {
        return $this->particip_start_date;
    }

    public function setParticipStartDate(?\DateTime $particip_start_date): static
    {
        $this->particip_start_date = $particip_start_date;

        return $this;
    }
}
