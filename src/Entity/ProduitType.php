<?php

namespace App\Entity;

use App\Repository\ProduitTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitTypeRepository::class)
 */
class ProduitType
{
    const PRODUIT_TYPE_EVENT_NAME = 'Evénement';
    const PRODUIT_TYPE_EVENT_SLUG = 'Evenement';

    const PRODUIT_TYPE_ADHESION_NAME = 'Adhésion';
    const PRODUIT_TYPE_ADHESION_SLUG = 'Adhesion';

    const PRODUIT_TYPE_DONATION_NAME = 'Donation';
    const PRODUIT_TYPE_DONATION_SLUG = 'Donation';

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
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="produitType")
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
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

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setProduitType($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getProduitType() === $this) {
                $produit->setProduitType(null);
            }
        }

        return $this;
    }
}
