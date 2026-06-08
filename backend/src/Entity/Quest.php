<?php

namespace App\Entity;

use App\Repository\QuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestRepository::class)]
class Quest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $quest_title = null;

    #[ORM\Column(length: 100)]
    private ?string $quest_badge = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $quest_description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $quest_rules = null;

    #[ORM\Column(length: 30)]
    private ?string $quest_difficulty = null;

    #[ORM\Column(length: 20)]
    private ?string $quest_criteria_type = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $quest_criteria_value = null;

    #[ORM\Column]
    private ?int $quest_criteria_target = null;

    /**
     * @var Collection<int, Participation>
     */
    #[ORM\OneToMany(targetEntity: Participation::class, mappedBy: 'quest')]
    private Collection $participations;

    public function __construct()
    {
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestTitle(): ?string
    {
        return $this->quest_title;
    }

    public function setQuestTitle(string $quest_title): static
    {
        $this->quest_title = $quest_title;
        return $this;
    }

    public function getQuestBadge(): ?string
    {
        return $this->quest_badge;
    }

    public function setQuestBadge(string $quest_badge): static
    {
        $this->quest_badge = $quest_badge;
        return $this;
    }

    public function getQuestDescription(): ?string
    {
        return $this->quest_description;
    }

    public function setQuestDescription(?string $quest_description): static
    {
        $this->quest_description = $quest_description;
        return $this;
    }

    public function getQuestRules(): ?string
    {
        return $this->quest_rules;
    }

    public function setQuestRules(?string $quest_rules): static
    {
        $this->quest_rules = $quest_rules;
        return $this;
    }

    public function getQuestDifficulty(): ?string
    {
        return $this->quest_difficulty;
    }

    public function setQuestDifficulty(string $quest_difficulty): static
    {
        $this->quest_difficulty = $quest_difficulty;
        return $this;
    }

    public function getQuestCriteriaType(): ?string
    {
        return $this->quest_criteria_type;
    }

    public function setQuestCriteriaType(string $quest_criteria_type): static
    {
        $this->quest_criteria_type = $quest_criteria_type;
        return $this;
    }

    public function getQuestCriteriaValue(): ?string
    {
        return $this->quest_criteria_value;
    }

    public function setQuestCriteriaValue(?string $quest_criteria_value): static
    {
        $this->quest_criteria_value = $quest_criteria_value;
        return $this;
    }

    public function getQuestCriteriaTarget(): ?int
    {
        return $this->quest_criteria_target;
    }

    public function setQuestCriteriaTarget(int $quest_criteria_target): static
    {
        $this->quest_criteria_target = $quest_criteria_target;
        return $this;
    }

    /**
     * @return Collection<int, Participation>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): static
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->setQuest($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): static
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getQuest() === $this) {
                $participation->setQuest(null);
            }
        }

        return $this;
    }
}