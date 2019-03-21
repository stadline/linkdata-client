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
 * @method Sport[]   getSports()
 * @method void      setSports($sports)
 * @method bool      isActive()
 * @method void      setActive(bool $active)
 * @method \DateTime getCreatedAt()
 * @method void      setCreatedAt(\DateTime $createdAt)
 * @method \DateTime getUpdatedAt()
 * @method void      setUpdatedAt(\DateTime $updatedAt)
 */
class Universe extends ProxyObject
{
    /**
     * @var int
     * @Groups({"universe_norm"})
     */
    public $id;

    /**
     * @var array
     * @Groups({"universe_norm"})
     */
    public $translatedNames;

    /**
     * @var Sport[]
     * @Groups({"universe_norm"})
     */
    public $sports = [];

    /**
     * @var bool
     * @Groups({"universe_norm"})
     */
    public $active = true;

    /**
     * @var \DateTime
     * @Groups({"universe_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"universe_norm"})
     */
    public $updatedAt;

    public function __construct()
    {
        $this->sports = [];
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
