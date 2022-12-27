<?php

namespace App\Entity;

use App\Repository\PetitionRepository;
use Attribute;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetitionRepository::class)]
class Petition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: Types::TEXT)]
    private string $title;

    #[ORM\Column(type: Types::TEXT)]
    private string $text;

    #[ORM\Column(type: Types::TEXT)]
    private string $subtitle;

    #[ORM\Column(type: Types::TEXT)]
    private string $target;

    #[ORM\Column(type: Types::TEXT)]
    private string $author;

    #[ORM\Column(type: Types::TEXT)]
    private string $target_to_whom;

    #[ORM\Column(type: Types::TEXT)]
    private string $author_to_whom;

    #[ORM\OneToMany(mappedBy: "petition", targetEntity: Signature::class)]
    private Collection $signatures;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private string $public_id;

    public function getSignatures(): Collection
    {
        return $this->signatures;
    }

    public function addSignature(Signature $signature): self
    {
        $this->signatures->add($signature);

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getTargetToWhom(): string
    {
        return $this->target_to_whom;
    }

    /**
     * @param string $target_to_whom
     */
    public function setTargetToWhom(string $target_to_whom): void
    {
        $this->target_to_whom = $target_to_whom;
    }

    /**
     * @return string
     */
    public function getAuthorToWhom(): string
    {
        return $this->author_to_whom;
    }

    /**
     * @param string $author_to_whom
     */
    public function setAuthorToWhom(string $author_to_whom): void
    {
        $this->author_to_whom = $author_to_whom;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getPublicId(): string
    {
        return $this->public_id;
    }

    public function setPublicId(string $public_id): self
    {
        $this->public_id = $public_id;

        return $this;
    }
}
