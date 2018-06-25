<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

class Universe
{
    /**
     * @var int
     *
     * @Groups({"universe_norm"})
     */
    private $id;

    /**
     * @var array
     *
     * @Groups({"universe_norm"})
     */
    private $translatedNames;

    /**
     * @var array
     *
     * @Groups({"universe_norm"})
     */
    private $sports;

    /**
     * @var bool
     *
     * @Groups({"universe_norm"})
     */
    private $active = true;

    /**
     * @var string
     *
     * @Groups({"universe_norm"})
     */
    private $createdAt;

    /**
     * @var string
     *
     * @Groups({"universe_norm"})
     */
    private $updatedAt;

    public function __construct()
    {
        $this->sports = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTranslatedNames(): ?array
    {
        return $this->translatedNames;
    }

    public function setTranslatedNames(?array $translatedNames): void
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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function hasNameByLocale(string $locale): ?bool
    {
        return isset($this->translatedNames[$locale]) && !empty($this->translatedNames[$locale]);
    }

    public function getNameByLocale(string $locale): ?string
    {
        return $this->hasNameByLocale($locale) ? $this->translatedNames[$locale] : null;
    }
}
