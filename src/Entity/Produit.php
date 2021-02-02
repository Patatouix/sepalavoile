<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
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
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $debutVente;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finVente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $limiteParticipation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=ProduitType::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produitType;

    /**
     * @ORM\OneToMany(targetEntity=Creneau::class, mappedBy="produit", orphanRemoval=true)
     */
    private $creneaux;

    /**
     * @ORM\OneToMany(targetEntity=Achat::class, mappedBy="produit")
     */
    private $achats;

    /**
     * @ORM\ManyToMany(targetEntity=Media::class, mappedBy="produits")
     */
    private $medias;

    public function __construct()
    {
        $this->creneaux = new ArrayCollection();
        $this->achats = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDebutVente(): ?\DateTimeInterface
    {
        return $this->debutVente;
    }

    public function setDebutVente(?\DateTimeInterface $debutVente): self
    {
        $this->debutVente = $debutVente;

        return $this;
    }

    public function getFinVente(): ?\DateTimeInterface
    {
        return $this->finVente;
    }

    public function setFinVente(?\DateTimeInterface $finVente): self
    {
        $this->finVente = $finVente;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getLimiteParticipation(): ?int
    {
        return $this->limiteParticipation;
    }

    public function setLimiteParticipation(?int $limiteParticipation): self
    {
        $this->limiteParticipation = $limiteParticipation;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getProduitType(): ?ProduitType
    {
        return $this->produitType;
    }

    public function setProduitType(?ProduitType $produitType): self
    {
        $this->produitType = $produitType;

        return $this;
    }

    /**
     * @return Collection|Creneau[]
     */
    public function getCreneaux(): Collection
    {
        return $this->creneaux;
    }

    public function addCreneaux(Creneau $creneaux): self
    {
        if (!$this->creneaux->contains($creneaux)) {
            $this->creneaux[] = $creneaux;
            $creneaux->setProduit($this);
        }

        return $this;
    }

    public function removeCreneaux(Creneau $creneaux): self
    {
        if ($this->creneaux->removeElement($creneaux)) {
            // set the owning side to null (unless already changed)
            if ($creneaux->getProduit() === $this) {
                $creneaux->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Achat[]
     */
    public function getAchats(): Collection
    {
        return $this->achats;
    }

    public function addAchat(Achat $achat): self
    {
        if (!$this->achats->contains($achat)) {
            $this->achats[] = $achat;
            $achat->setProduit($this);
        }

        return $this;
    }

    public function removeAchat(Achat $achat): self
    {
        if ($this->achats->removeElement($achat)) {
            // set the owning side to null (unless already changed)
            if ($achat->getProduit() === $this) {
                $achat->setProduit(null);
            }
        }

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
            $media->addProduit($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            $media->removeProduit($this);
        }

        return $this;
    }

    public function getParticipation(): ?int
    {
        if ($this->getProduitType()->getNom() == ProduitType::PRODUIT_TYPE_DONATION_NAME) {
            $participation = 0;
            foreach ($this->getAchats() as $achat) {
                $participation += $achat->getPrixPaye();
            }
        } elseif ($this->getProduitType()->getNom() == ProduitType::PRODUIT_TYPE_ADHESION_NAME) {
            $participation = count($this->getAchats());
        }

        return $participation;
    }

    public function getPercentageParticipation()
    {
        $percentage = ( $this->getParticipation() / $this->getLimiteParticipation() ) * 100;
        return $percentage;
    }
}
