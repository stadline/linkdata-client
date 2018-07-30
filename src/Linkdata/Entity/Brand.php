<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\src\Linkdata\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Stadline\LinkdataClient\src\ClientHydra\Proxy\ProxyObject;

class Brand extends ProxyObject
{
    /**
     * @var int
     * @Groups({"brand_norm"})
     */
    private $id;

    /**
     * @var ArrayCollection
     */
    private $deviceModels;

    /**
     * @var array
     *
     * @Groups({"brand_norm"})
     */
    private $translatedNames;

    /**
     * @var bool
     * @Groups({"brand_norm"})
     */
    private $active = true;

    /**
     * @var string
     * @Groups({"brand_norm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"brand_norm"})
     */
    private $updatedAt;

    public function addDeviceModel(DeviceModel $deviceModel): void
    {
        $this->deviceModels[] = $deviceModel;
    }

    public function removeDeviceModel(DeviceModel $deviceModel): void
    {
        $this->deviceModels->removeElement($deviceModel);
    }

    public function getDeviceModels(): Collection
    {
        return $this->deviceModels;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
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

    public function __toString(): string
    {
        return $this->translatedNames['en'];
    }
}
