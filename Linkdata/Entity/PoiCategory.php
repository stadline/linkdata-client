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
class PoiCategory extends ProxyObject
{
    /**
     * @var int
     * @Groups({"poi_category_norm"})
     */
    public $id;

    /**
     * @var array
     * @Groups({"poi_category_norm"})
     */
    public $translatedNames;

    /**
     * @var bool
     * @Groups({"poi_category_norm"})
     */
    public $active;

    /**
     * @var \DateTime
     * @Groups({"poi_category_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"poi_category_norm"})
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
}
