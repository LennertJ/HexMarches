<?php

namespace App\Entity;

use App\Repository\DungeonMasterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DungeonMasterRepository::class)
 */
class DungeonMaster
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
    private $DungeonMasterId;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $DungeonMasterName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDungeonMasterId(): ?string
    {
        return $this->DungeonMasterId;
    }

    public function setDungeonMasterId(string $DungeonMasterId): self
    {
        $this->DungeonMasterId = $DungeonMasterId;

        return $this;
    }

    public function getDungeonMasterName(): ?string
    {
        return $this->DungeonMasterName;
    }

    public function setDungeonMasterName(?string $DungeonMasterName): self
    {
        $this->DungeonMasterName = $DungeonMasterName;

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
