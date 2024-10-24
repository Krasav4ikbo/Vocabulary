<?php

namespace App\Entity;

use App\Repository\TranslationResultsRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: TranslationResultsRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class TranslationResults extends BaseEntity
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $uuid;

    #[ORM\ManyToOne(inversedBy: 'translationResults')]
    #[ORM\JoinColumn(name: 'user_uuid', referencedColumnName: 'uuid', nullable: true)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Word::class, inversedBy: 'translationResults')]
    #[ORM\JoinColumn(name: 'word_uuid', referencedColumnName: 'uuid', nullable: true, onDelete: 'cascade')]
    private ?Word $word = null;


    #[ORM\Column]
    private ?int $succeed = null;

    #[ORM\Column]
    private ?int $failed = null;

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

    public function getSucceed(): ?int
    {
        return $this->succeed;
    }

    public function setSucceed(int $succeed): static
    {
        $this->succeed = $succeed;

        return $this;
    }

    public function getFailed(): ?int
    {
        return $this->failed;
    }

    public function setFailed(int $failed): static
    {
        $this->failed = $failed;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): void
    {
        $this->word = $word;
    }

    public function succeedIncreece()
    {
        $this->succeed++;

        return $this;
    }

    public function failedIncreece()
    {
        $this->failed++;

        return $this;
    }
}
