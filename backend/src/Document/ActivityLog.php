<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

#[ODM\Document]
class ActivityLog 
{ 
    #[ODM\Id]
    private ?string $id = null;

    #[ODM\Field(type: 'int')]
    private ?int $user_id = null;

    #[ODM\Field(type: 'string')]
    private ?string $action = null;

    #[ODM\Field(type: 'string')]
    private ?string $details = null;

    #[ODM\Field(type: 'date')]
    private ?\DateTime $createAt = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

     public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;
        return $this;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;
        return $this;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;
        return $this;
    }

    public function setCreateAt(\DateTime $createAt): static
    {
        $this->createAt = $createAt;
        return $this;
    }

}