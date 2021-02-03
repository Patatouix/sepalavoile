<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbVues = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedDateStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedDateEnd;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\ManyToMany(targetEntity=ArticleCategorie::class, mappedBy="Articles")
     */
    private $articleCategories;

    /**
     * @ORM\ManyToMany(targetEntity=Media::class)
     */
    private $medias;

    public function __construct()
    {
        $this->articleCategories = new ArrayCollection();
        $this->medias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

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

    public function getNbVues(): ?int
    {
        return $this->nbVues;
    }

    public function setNbVues(int $nbVues): self
    {
        $this->nbVues = $nbVues;

        return $this;
    }

    public function getPublishedDateStart(): ?\DateTimeInterface
    {
        return $this->publishedDateStart;
    }

    public function setPublishedDateStart(?\DateTimeInterface $publishedDateStart): self
    {
        $this->publishedDateStart = $publishedDateStart;

        return $this;
    }

    public function getPublishedDateEnd(): ?\DateTimeInterface
    {
        return $this->publishedDateEnd;
    }

    public function setPublishedDateEnd(?\DateTimeInterface $publishedDateEnd): self
    {
        $this->publishedDateEnd = $publishedDateEnd;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return Collection|ArticleCategorie[]
     */
    public function getArticleCategories(): Collection
    {
        return $this->articleCategories;
    }

    public function addArticleCategory(ArticleCategorie $articleCategory): self
    {
        if (!$this->articleCategories->contains($articleCategory)) {
            $this->articleCategories[] = $articleCategory;
            $articleCategory->addArticle($this);
        }

        return $this;
    }

    public function removeArticleCategory(ArticleCategorie $articleCategory): self
    {
        if ($this->articleCategories->removeElement($articleCategory)) {
            $articleCategory->removeArticle($this);
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
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        $this->medias->removeElement($media);

        return $this;
    }
}
