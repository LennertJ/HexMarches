<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\Table(name="`character`")
 */
class Character
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $CharacterId;

    /**
     * @ORM\Column(type="integer")
     */
    private $PlayerId;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     */
    public function setName($Name): void
    {
        $this->Name = $Name;
    }

    /**
     * @ORM\Column(type="string", length=63, nullable=false)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PictureUrl;

    /**
     * @return mixed
     */
    public function getPictureUrl()
    {
        return $this->PictureUrl;
    }

    /**
     * @param mixed $PictureUrl
     */
    public function setPictureUrl($PictureUrl): void
    {
        $this->PictureUrl = $PictureUrl;
    }

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $Race;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $Class;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $Level;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $NextSessionId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $LastSessionId;

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

    public function getPlayerId(): ?int
    {
        return $this->PlayerId;
    }

    public function setPlayerId(int $PlayerId): self
    {
        $this->PlayerId = $PlayerId;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->Race;
    }

    public function setRace(?string $Race): self
    {
        $this->Race = $Race;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->Class;
    }

    public function setClass(?string $Class): self
    {
        $this->Class = $Class;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->Level;
    }

    public function setLevel(?int $Level): self
    {
        $this->Level = $Level;

        return $this;
    }

    public function getNextSessionId(): ?int
    {
        return $this->NextSessionId;
    }

    public function setNextSessionId(?int $NextSessionId): self
    {
        $this->NextSessionId = $NextSessionId;

        return $this;
    }

    public function getLastSessionId(): ?int
    {
        return $this->LastSessionId;
    }

    public function setLastSessionId(?int $LastSessionId): self
    {
        $this->LastSessionId = $LastSessionId;

        return $this;
    }

    public function toString(){
        return $this->getId() . " " . $this->getName() . " " .  $this->getClass() .
            " " . $this->getRace() . " " . $this->getDescription() . " " . $this->getLevel()
            . " " . $this->getPictureUrl() . " " . $this->getPlayerId() . " " . $this->getLastSessionId()
            . " " . $this->getNextSessionId();
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
