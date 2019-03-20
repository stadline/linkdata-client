<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string          getId()
 * @method void            setId(string $id)
 * @method ArrayCollection getDeviceModels()
 * @method void            setDeviceModels()
 * @method array           getTranslatedNames()
 * @method void            setTranslatedNames()
 * @method bool            isActive()
 * @method void            setActive()
 * @method string          getCreatedAt()
 * @method void            setCreatedAt(string $createdAt)
 * @method string          getUpdatedAt()
 * @method void            setUpdatedAt(string $updatedAt)
 */
class Brand extends ProxyObject
{
    /**
     * @var int
     * @Groups({"brand_norm"})
     */
    public $id;

    /**
     * @var ArrayCollection
     */
    public $deviceModels;

    /**
     * @var array
     * @Groups({"brand_norm"})
     */
    public $translatedNames;

    /**
     * @var bool
     * @Groups({"brand_norm"})
     */
    public $active = true;

    /**
     * @var string
     * @Groups({"brand_norm"})
     */
    public $createdAt;

    /**
     * @var string
     * @Groups({"brand_norm"})
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

    public function __toString(): string
    {
        return (string) $this->translatedNames['en'];
    }
}
