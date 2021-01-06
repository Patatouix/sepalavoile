<?php

namespace App\Entity;

use App\Repository\ArticleControllerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleControllerRepository::class)
 */
class ArticleController
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nbVues;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedDateStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedDateEnd;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPublished;

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

    public function getNbVues(): ?string
    {
        return $this->nbVues;
    }

    public function setNbVues(?string $nbVues): self
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

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
