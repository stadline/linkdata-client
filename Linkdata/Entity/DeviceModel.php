<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

class DeviceModel extends ProxyObject
{
    const ONCOACH = 1;
    const ONMOVE510710 = 7;
    const ONDAILY = 13;
    const SATCOUNT = 23;
    const FORERUNNER_10 = 27;
    const FORERUNNER_110 = 28;
    const FORERUNNER_205 = 29;
    const FORERUNNER_210 = 30;
    const FORERUNNER_220 = 31;
    const FORERUNNER_305 = 32;
    const FORERUNNER_310XT = 33;
    const FORERUNNER_405 = 34;
    const FORERUNNER_405CX = 35;
    const FORERUNNER_410 = 36;
    const FORERUNNER_610 = 37;
    const FORERUNNER_620 = 38;
    const FORERUNNER_910 = 39;
    const FORERUNNER_15 = 40;
    const EDGE_200 = 41;
    const EDGE_210 = 42;
    const EDGE_500 = 43;
    const EDGE_510 = 44;
    const EDGE_800 = 45;
    const EDGE_810 = 46;
    const GARMIN_COMMUNICATOR = 47;
    const ONCOACH100 = 61;

    /**
     * @var int
     * @Groups({"device_model_norm"})
     */
    private $id;

    /**
     * @var array
     *
     * @Groups({"device_model_norm"})
     */
    private $translatedNames;

    /**
     * @var Brand
     * @Groups({"device_model_norm"})
     */
    private $brand;

    /**
     * @var string
     * @Groups({"device_model_norm"})
     */
    private $serialRange;

    /**
     * @var int
     * @Groups({"device_model_norm"})
     */
    private $coder3;

    /**
     * @var string
     * @Groups({"device_model_norm"})
     */
    private $notice;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    private $hasNotificationChallenge = false;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    private $hasNotificationRoute = false;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    private $hasNotificationPoi = false;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    private $hasCoaching = false;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    private $usedForGlobalChallenge = true;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    private $active = true;

    /**
     * @var string
     * @Groups({"device_model_norm"})
     */
    private $createdAt;

    /**
     * @var string
     * @Groups({"device_model_norm"})
     */
    private $updatedAt;

    /**
     * @var ArrayCollection
     */
    private $firmwares;

    public function getFirmwares(): Collection
    {
        return $this->firmwares;
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

    public function getBrand()
    {
        return $this->hydrate($this->brand);
    }

    public function setBrand($brand): void
    {
        $this->brand = $brand;
    }

    public function getSerialRange(): ?string
    {
        return $this->serialRange;
    }

    public function setSerialRange(?string $serialRange): void
    {
        $this->serialRange = $serialRange;
    }

    public function getCoder3(): ?int
    {
        return $this->coder3;
    }

    public function setCoder3(?int $coder3): void
    {
        $this->coder3 = $coder3;
    }

    public function getNotice(): ?string
    {
        return $this->notice;
    }

    public function setNotice(?string $notice): void
    {
        $this->notice = $notice;
    }

    public function isHasNotificationChallenge(): bool
    {
        return $this->hasNotificationChallenge;
    }

    public function setHasNotificationChallenge(bool $hasNotificationChallenge): void
    {
        $this->hasNotificationChallenge = $hasNotificationChallenge;
    }

    public function isHasNotificationRoute(): bool
    {
        return $this->hasNotificationRoute;
    }

    public function setHasNotificationRoute(bool $hasNotificationRoute): void
    {
        $this->hasNotificationRoute = $hasNotificationRoute;
    }

    public function isHasNotificationPoi(): bool
    {
        return $this->hasNotificationPoi;
    }

    public function setHasNotificationPoi(bool $hasNotificationPoi): void
    {
        $this->hasNotificationPoi = $hasNotificationPoi;
    }

    public function isHasCoaching(): bool
    {
        return $this->hasCoaching;
    }

    public function setHasCoaching(bool $hasCoaching): void
    {
        $this->hasCoaching = $hasCoaching;
    }

    public function getUsedForGlobalChallenge(): bool
    {
        return $this->usedForGlobalChallenge;
    }

    public function setUsedForGlobalChallenge(bool $usedForGlobalChallenge): void
    {
        $this->usedForGlobalChallenge = $usedForGlobalChallenge;
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
}
