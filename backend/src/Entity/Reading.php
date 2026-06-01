<?php

namespace App\Entity;

use App\Repository\ReadingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReadingRepository::class)]
class Reading
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $reading_status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $reading_begin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $reading_end = null;

    #[ORM\ManyToOne(inversedBy: 'readings')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'readings')]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReadingStatus(): ?string
    {
        return $this->reading_status;
    }

    public function setReadingStatus(string $reading_status): static
    {
        $this->reading_status = $reading_status;

        return $this;
    }

    public function getReadingBegin(): ?\DateTime
    {
        return $this->reading_begin;
    }

    public function setReadingBegin(?\DateTime $reading_begin): static
    {
        $this->reading_begin = $reading_begin;

        return $this;
    }

    public function getReadingEnd(): ?\DateTime
    {
        return $this->reading_end;
    }

    public function setReadingEnd(?\DateTime $reading_end): static
    {
        $this->reading_end = $reading_end;

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

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }
}
