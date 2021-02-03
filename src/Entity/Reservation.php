<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantitePlaces;

    /**
     * @ORM\Column(type="float")
     */
    private $prixPaye;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Creneau::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creneau;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantitePlaces(): ?int
    {
        return $this->quantitePlaces;
    }

    public function setQuantitePlaces(int $quantitePlaces): self
    {
        $this->quantitePlaces = $quantitePlaces;

        return $this;
    }

    public function getPrixPaye(): ?float
    {
        return $this->prixPaye;
    }

    public function setPrixPaye(float $prixPaye): self
    {
        $this->prixPaye = $prixPaye;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreneau(): ?Creneau
    {
        return $this->creneau;
    }

    public function setCreneau(?Creneau $creneau): self
    {
        $this->creneau = $creneau;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
