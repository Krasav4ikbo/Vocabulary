<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\HasLifecycleCallbacks()]
class User extends BaseEntity implements UserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $uuid;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $login = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $apiKey = null;

    /**
     * @var Collection<int, TranslationResults>
     */
    #[ORM\OneToMany(targetEntity: TranslationResults::class, mappedBy: 'user_uuid')]
    private Collection $translationResults;

    public function __construct()
    {
        $this->translationResults = new ArrayCollection();
    }

    public function getUuid(): ?UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->uuid;
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
            $translationResult->setUserUuid($this);
        }

        return $this;
    }

    public function removeTranslationResult(TranslationResults $translationResult): static
    {
        if ($this->translationResults->removeElement($translationResult)) {
            // set the owning side to null (unless already changed)
            if ($translationResult->getUserUuid() === $this) {
                $translationResult->setUserUuid(null);
            }
        }

        return $this;
    }
}
