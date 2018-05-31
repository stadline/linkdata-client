<?php

declare(strict_types=1);

namespace Geonaute\LinkdataClient\Entity;

use DateTime;

class Universe
{
    /**
     * @var int
     *
     * @Serializer\SerializedName("id")
     * @Serializer\Type("int")
     */
    private $id;

    /**
     * @var array
     *
     * @Serializer\SerializedName("translatedNames")
     * @Serializer\Type("array")
     */
    private $translatedNames;

    /**
     * @var array
     *
     * @Serializer\SerializedName("sports")
     * @Serializer\Type("array<Geonaute\LinkdataClient\Entity\Sport>")
     */
    private $sports;

    /**
     * @var bool
     *
     * @Serializer\SerializedName("active")
     * @Serializer\Type("bool")
     */
    private $active = true;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("createdAt")
     * @Serializer\Type("DateTime")
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @Serializer\SerializedName("updatedAt")
     * @Serializer\Type("DateTime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->sports = [];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTranslatedNames(): array
    {
        return $this->translatedNames;
    }

    public function setTranslatedNames(array $translatedNames): void
    {
        $this->translatedNames = $translatedNames;
    }

    public function addSport(Sport $sport): void
    {
        $this->sports[] = $sport;
    }

    public function removeSport(Sport $sport): void
    {
        //todo implement the method
    }

    public function getSports(): array
    {
        return $this->sports;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function hasNameByLocale(string $locale): bool
    {
        return isset($this->translatedNames[$locale]) && !empty($this->translatedNames[$locale]);
    }

    public function getNameByLocale(string $locale): ?string
    {
        return $this->hasNameByLocale($locale) ? $this->translatedNames[$locale] : null;
    }
}
