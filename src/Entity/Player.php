<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=63, nullable=false)
     */
    private $PlayerId;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $PlayerName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayerId(): ?string
    {
        return $this->PlayerId;
    }

    public function setPlayerId(string $PlayerId): self
    {
        $this->PlayerId = $PlayerId;

        return $this;
    }

    public function getPlayerName(): ?string
    {
        return $this->PlayerName;
    }

    public function setPlayerName(?string $PlayerName): self
    {
        $this->PlayerName = $PlayerName;

        return $this;
    }
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
