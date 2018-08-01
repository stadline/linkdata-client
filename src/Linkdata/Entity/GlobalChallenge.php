<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use Stadline\LinkdataClient\src\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class GlobalChallenge extends ProxyObject
{
    const STATE_BEFORE = -1;
    const STATE_CURRENT = 0;
    const STATE_AFTER = 1;

    /**
     * @var string
     * @Groups({"global_challenge_norm"})
     */
    private $id;

    /**
     * @var array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $translatedNames;

    /**
     * @var Datatype
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $targetDatatype;

    /**
     * @var array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $translatedBeforeMessage;

    /**
     * @var array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $translatedCurrentMessage;

    /**
     * @var array
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $translatedAfterMessage;

    /**
     * @var string
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $publishDate;

    /**
     * @var string
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $startedAt;

    /**
     * @var string
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $endedAt;

    /**
     * @var int
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $target;

    /**
     * @var int
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $result = 0;

    /**
     * @var string
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $imageUrl;

    /**
     * @var bool
     * @Groups({"global_challenge_norm", "global_challenge_denorm"})
     */
    private $active = true;

    /**
     * @var string
     * @Groups({"global_challenge_norm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"global_challenge_norm"})
     */
    private $updatedAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getTargetDatatype(): ?Datatype
    {
        return $this->hydrate($this->targetDatatype);
    }

    public function setTargetDatatype($targetDatatype): void
    {
        $this->targetDatatype = $targetDatatype;
    }

    public function getTranslatedBeforeMessage(): ?array
    {
        return $this->translatedBeforeMessage;
    }

    public function setTranslatedBeforeMessage(?array $translatedBeforeMessage): void
    {
        $this->translatedBeforeMessage = $translatedBeforeMessage;
    }

    public function getTranslatedCurrentMessage(): ?array
    {
        return $this->translatedCurrentMessage;
    }

    public function setTranslatedCurrentMessage(?array $translatedCurrentMessage): void
    {
        $this->translatedCurrentMessage = $translatedCurrentMessage;
    }

    public function getTranslatedAfterMessage(): ?array
    {
        return $this->translatedAfterMessage;
    }

    public function setTranslatedAfterMessage(?array $translatedAfterMessage): void
    {
        $this->translatedAfterMessage = $translatedAfterMessage;
    }

    public function getPublishDate(): ?string
    {
        return $this->publishDate;
    }

    public function setPublishDate(?string $publishDate): void
    {
        $this->publishDate = $publishDate;
    }

    public function getStartedAt(): ?string
    {
        return $this->startedAt;
    }

    public function setStartedAt(?string $startedAt): void
    {
        $this->startedAt = $startedAt;
    }

    public function getEndedAt(): ?string
    {
        return $this->endedAt;
    }

    public function setEndedAt(?string $endedAt): void
    {
        $this->endedAt = $endedAt;
    }

    public function getTarget(): ?int
    {
        return $this->target;
    }

    public function setTarget(?int $target): void
    {
        $this->target = $target;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): void
    {
        $this->result = $result;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getTranslatedNames(): array
    {
        return $this->translatedNames;
    }

    public function setTranslatedNames(array $translatedNames): void
    {
        $this->translatedNames = $translatedNames;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function hasNameByLocale(string $locale): bool
    {
        return isset($this->translatedNames[$locale]) && !empty($this->translatedNames[$locale]);
    }

    public function getNameByLocale(string $locale): ?string
    {
        return $this->hasNameByLocale($locale) ? $this->translatedNames[$locale] : null;
    }

    /**
     * Returns challenge state (BEFORE / CURRENT / AFTER).
     *
     * @return int
     */
    public function getState()
    {
        $now = new \DateTime();
        $startedAt = $this->getStartedAtAsDateTimeObject();
        $endedAt = $this->getEndedAtAsDateTimeObject();

        if ($startedAt > $now) {
            return self::STATE_BEFORE;
        }
        if ($this->endedAt && $now >= $endedAt) {
            return self::STATE_AFTER;
        }

        return self::STATE_CURRENT;
    }

    /**
     * @return \DateTime
     */
    public function getStartedAtAsDateTimeObject()
    {
        $startedAt = new \DateTime($this->startedAt);

        return \DateTime::createFromFormat('Y-m-d H:i:s', $startedAt);
    }

    /**
     * @return \DateTime
     */
    public function getEndedAtAsDateTimeObject()
    {
        $endedAt = new \DateTime($this->endedAt);

        return \DateTime::createFromFormat('Y-m-d H:i:s', $endedAt);
    }

    /**
     * @return bool
     */
    public function isOver()
    {
        return self::STATE_AFTER === $this->getState();
    }

    /**
     * @return bool
     */
    public function isInProgress()
    {
        return self::STATE_CURRENT === $this->getState();
    }

    /**
     * @return bool
     */
    public function isNotStarted()
    {
        return self::STATE_BEFORE === $this->getState();
    }

    /**
     * @return bool
     */
    public function isDistance()
    {
        return Datatype::DISTANCE === $this->getTargetDatatype()->getId();
    }
}
