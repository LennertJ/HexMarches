<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $SessionId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\Column(type="integer")
     */
    private $DungeonMasterId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Objective;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SessionNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SessionStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionId(): ?int
    {
        return $this->SessionId;
    }

    public function setSessionId(int $SessionId): self
    {
        $this->SessionId = $SessionId;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getDungeonMasterId(): ?int
    {
        return $this->DungeonMasterId;
    }

    public function setDungeonMasterId(int $DungeonMasterId): self
    {
        $this->DungeonMasterId = $DungeonMasterId;

        return $this;
    }

    public function getObjective(): ?string
    {
        return $this->Objective;
    }

    public function setObjective(?string $Objective): self
    {
        $this->Objective = $Objective;

        return $this;
    }

    public function getSessionNumber(): ?string
    {
        return $this->SessionNumber;
    }

    public function setSessionNumber(?string $SessionNumber): self
    {
        $this->SessionNumber = $SessionNumber;

        return $this;
    }

    public function getSessionStatus(): ?string
    {
        return $this->SessionStatus;
    }

    public function setSessionStatus(?string $SessionStatus): self
    {
        $this->SessionStatus = $SessionStatus;

        return $this;
    }
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
