<?php

namespace App\Entity;

use App\Repository\GalerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GalerieRepository::class)
 */
class Galerie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descritpion;

   
    /**
     * @ORM\ManyToMany(targetEntity=GalerieCategorie::class, inversedBy="galeries")
     */
    private $GalerieCategorie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Media::class, inversedBy="galeries")
     */
    private $medias;

    public function __construct()
    {
        $this->Media = new ArrayCollection();
        $this->GalerieCategorie = new ArrayCollection();
        $this->medias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescritpion(): ?string
    {
        return $this->descritpion;
    }

    public function setDescritpion(?string $descritpion): self
    {
        $this->descritpion = $descritpion;

        return $this;
    }

    /**
     * @return Collection|GalerieCategorie[]
     */
    public function getGalerieCategorie(): Collection
    {
        return $this->GalerieCategorie;
    }

    public function addGalerieCategorie(GalerieCategorie $galerieCategorie): self
    {
        if (!$this->GalerieCategorie->contains($galerieCategorie)) {
            $this->GalerieCategorie[] = $galerieCategorie;
        }

        return $this;
    }

    public function removeGalerieCategorie(GalerieCategorie $galerieCategorie): self
    {
        $this->GalerieCategorie->removeElement($galerieCategorie);

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

    /**
     * @return Collection|Media[]
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias[] = $media;
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        $this->medias->removeElement($media);

        return $this;
    }
}
