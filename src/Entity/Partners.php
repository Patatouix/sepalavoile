<?php

namespace App\Entity;

use App\Repository\PartnersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartnersRepository::class)
 */
class Partners
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $webSite;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, inversedBy="partners")
     */
    private $media;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWebSite(): ?string
    {
        return $this->webSite;
    }

    public function setWebSite(string $webSite): self
    {
        $this->webSite = $webSite;

        return $this;
    }

    public function getMedia(): ?media
    {
        return $this->media;
    }

    public function setMedia(?media $media): self
    {
        $this->media = $media;

        return $this;
    }
    
}
