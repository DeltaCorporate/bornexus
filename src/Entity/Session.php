<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $started_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedDate(): ?\DateTimeImmutable
    {
        return $this->started_date;
    }

    public function setStartedDate(\DateTimeImmutable $started_date): static
    {
        $this->started_date = $started_date;

        return $this;
    }
}
