<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method int       getId()
 * @method void      setId(int $id)
 * @method array     getTranslatedNames()
 * @method void      setTranslatedNames(array $translatedNames)
 * @method Brand     getBrand()
 * @method void      setBrand(Brand $brand)
 * @method ?string   getSerialRange()
 * @method void      setSerialRange(?string $serialRange)
 * @method ?int      getCoder3()
 * @method void      setCoder3(?int $coder3)
 * @method ?string   getNotice()
 * @method void      setNotice(?string $notice)
 * @method bool      isHasNotificationChallenge()
 * @method void      setHasNotificationChallenge(bool $hasNotificationChallenge)
 * @method bool      isHasNotificationRoute()
 * @method void      setHasNotificationRoute(bool $hasNotificationRoute)
 * @method bool      isHasNotificationPoi()
 * @method void      setHasNotificationPoi(bool $hasNotificationPoi)
 * @method bool      isHasCoaching()
 * @method void      setHasCoaching(bool $hasCoaching)
 * @method bool      isUsedForGlobalChallenge()
 * @method void      setUsedForGlobalChallenge(bool $usedForGlobalChallenge)
 * @method bool      isActive()
 * @method void      setActive(bool $active)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
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
    public $id;

    /**
     * @var array
     * @Groups({"device_model_norm"})
     */
    public $translatedNames;

    /**
     * @var Brand
     * @Groups({"device_model_norm"})
     */
    public $brand;

    /**
     * @var ?string
     * @Groups({"device_model_norm"})
     */
    public $serialRange;

    /**
     * @var ?int
     * @Groups({"device_model_norm"})
     */
    public $coder3;

    /**
     * @var ?string
     * @Groups({"device_model_norm"})
     */
    public $notice;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    public $hasNotificationChallenge = false;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    public $hasNotificationRoute = false;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    public $hasNotificationPoi = false;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    public $hasCoaching = false;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    public $usedForGlobalChallenge = true;

    /**
     * @var bool
     * @Groups({"device_model_norm"})
     */
    public $active = true;

    /**
     * @var \DateTime
     * @Groups({"device_model_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"device_model_norm"})
     */
    public $updatedAt;

    public function hasNameByLocale(string $locale): bool
    {
        return isset($this->translatedNames[$locale]) && !empty($this->translatedNames[$locale]);
    }

    public function getNameByLocale(string $locale): ?string
    {
        return $this->hasNameByLocale($locale) ? $this->translatedNames[$locale] : null;
    }
}
