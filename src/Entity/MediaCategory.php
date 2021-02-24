<?php

namespace App\Entity;

use App\Repository\MediaCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediaCategoryRepository::class)
 */
class MediaCategory
{

    const MEDIA_CATEGORY_IMAGE_NAME = 'Image';
    // const PRODUIT_TYPE_EVENT_SLUG = 'image';

    const MEDIA_CATEGORY_VIDEO_NAME = 'Vidéo';
    // const PRODUIT_TYPE_ADHESION_SLUG = 'video';

    const MEDIA_CATEGORY_SLIDERPHOTO_NAME = 'Slider photo';
    // const PRODUIT_TYPE_DONATION_SLUG = 'sliderPhoto';

    const MEDIA_CATEGORY_HEADERVIDEO_NAME = 'Header vidéo';
    // const PRODUIT_TYPE_DONATION_SLUG = 'headerVideo';

    const MEDIA_CATEGORY_FICHIER_NAME = 'Fichier';
    // const PRODUIT_TYPE_DONATION_SLUG = 'fichier';

    // const MEDIA_CATEGORY_GALERIEIMAGE_NAME = 'Galerie image';
    // const PRODUIT_TYPE_DONATION_SLUG = 'galerieVideo';

    // const MEDIA_CATEGORY_GALERIEVIDEO_NAME = 'Galerie vidéo';
    // const PRODUIT_TYPE_DONATION_SLUG = 'galerieVideo';

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
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="mediaCategory")
     */
    private $Medias;

    public function __construct()
    {
        $this->Medias = new ArrayCollection();
    }

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

    /**
     * @return Collection|Media[]
     */
    public function getMedias(): Collection
    {
        return $this->Medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->Medias->contains($media)) {
            $this->Medias[] = $media;
            $media->setMediaCategory($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->Medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getMediaCategory() === $this) {
                $media->setMediaCategory(null);
            }
        }

        return $this;
    }
}
