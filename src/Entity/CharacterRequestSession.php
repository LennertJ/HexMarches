<?php

namespace App\Entity;

use App\Repository\CharacterRequestSessionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterRequestSessionRepository::class)
 */
class CharacterRequestSession
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
    private $RequestId;

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

    public function getRequestId(): ?int
    {
        return $this->RequestId;
    }

    public function setRequestId(int $RequestId): self
    {
        $this->RequestId = $RequestId;

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
