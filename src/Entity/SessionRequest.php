<?php

namespace App\Entity;

use App\Repository\SessionRequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRequestRepository::class)
 */
class SessionRequest
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
    private $RequestId;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $Date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Objective;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?string

    {
        return $this->Date;
    }

    public function setDate(string $Date): self
    {
        $this->Date = $Date;

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

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
