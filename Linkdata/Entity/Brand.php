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
 * @method bool      isActive()
 * @method void      setActive(bool $active)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class Brand extends ProxyObject
{
    /**
     * @var int
     * @Groups({"brand_norm"})
     */
    public $id;

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
     * @var \DateTime
     * @Groups({"brand_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"brand_norm"})
     */
    public $updatedAt;

    public function hasNameByLocale(string $locale): ?bool
    {
        return isset($this->getTranslatedNames()[$locale]) && !empty($this->getTranslatedNames()[$locale]);
    }

    public function getNameByLocale(string $locale): ?string
    {
        return $this->hasNameByLocale($locale) ? $this->getTranslatedNames()[$locale] : null;
    }

    public function __toString(): string
    {
        return (string) $this->getTranslatedNames()['en'];
    }
}
