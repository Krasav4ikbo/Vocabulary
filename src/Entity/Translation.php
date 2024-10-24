<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: TranslationRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Translation extends BaseEntity
{
    #[ORM\Id]
    #[ORM\Column(type: "string", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $uuid;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 3)]
    private ?string $language = null;

    #[ORM\ManyToOne(targetEntity: Word::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'word_uuid', referencedColumnName: 'uuid', nullable: true, onDelete: 'cascade')]
    private ?Word $word;

    public function getId(): UuidInterface|string
    {
        return $this->uuid;
    }

    public function getUuid(): UuidInterface|string
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface|string $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): static
    {
        $this->word = $word;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
