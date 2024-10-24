<?php

namespace App\Entity;

use App\Repository\WordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: WordRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Word extends BaseEntity
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $uuid;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\Column]
    private ?int $complexity = null;

    /**
     * @var Collection<int, Translation>
     */
    #[ORM\OneToMany(targetEntity: Translation::class, mappedBy: 'word')]
    private Collection $translations;

    private string $translation;

    /**
     * @var Collection<int, TranslationResults>
     */
    #[ORM\OneToMany(targetEntity: TranslationResults::class, mappedBy: 'word')]
    private Collection $translationResults;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->translationResults = new ArrayCollection();
    }

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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getComplexity(): ?int
    {
        return $this->complexity;
    }

    public function setComplexity(int $complexity): static
    {
        $this->complexity = $complexity;

        return $this;
    }

    /**
     * @return Collection<int, Translation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(Translation $translation): static
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setWord($this);
        }

        return $this;
    }

    public function removeTranslation(Translation $translation): static
    {
        if ($this->translations->removeElement($translation)) {
            // set the owning side to null (unless already changed)
            if ($translation->getWord() === $this) {
                $translation->setWord(null);
            }
        }

        return $this;
    }

    public function getTranslation(): string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): void
    {
        $this->translation = $translation;
    }

    /**
     * @return Collection<int, TranslationResults>
     */
    public function getTranslationResults(): Collection
    {
        return $this->translationResults;
    }

    public function addTranslationResult(TranslationResults $translationResult): static
    {
        if (!$this->translationResults->contains($translationResult)) {
            $this->translationResults->add($translationResult);
            $translationResult->setWordUuid($this);
        }

        return $this;
    }

    public function removeTranslationResult(TranslationResults $translationResult): static
    {
        if ($this->translationResults->removeElement($translationResult)) {
            // set the owning side to null (unless already changed)
            if ($translationResult->getWordUuid() === $this) {
                $translationResult->setWordUuid(null);
            }
        }

        return $this;
    }
}
