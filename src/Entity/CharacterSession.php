<?php

namespace App\Entity;

use App\Repository\CharacterSessionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterSessionRepository::class)
 */
class CharacterSession
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
    private $CharacterId;

    /**
     * @ORM\Column(type="integer")
     */
    private $SessionId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacterId(): ?int
    {
        return $this->CharacterId;
    }

    public function setCharacterId(int $CharacterId): self
    {
        $this->CharacterId = $CharacterId;

        return $this;
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

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
