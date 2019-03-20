<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string  getId()
 * @method void    setId(string $id)
 * @method array   getTranslatedNames()
 * @method void    setTranslatedNames(array $translatedNames)
 * @method Sport[] getSports()
 * @method void    setSports($sports)
 * @method bool    isActive()
 * @method void    setActive(bool $active)
 * @method string  getCreatedAt()
 * @method void    setCreatedAt(string $createdAt)
 * @method string  getUpdatedAt()
 * @method void    setUpdatedAt(string $updatedAt)
 */
class Universe extends ProxyObject
{
    /**
     * @var int
     *
     * @Groups({"universe_norm"})
     */
    public $id;

    /**
     * @var array
     *
     * @Groups({"universe_norm"})
     */
    public $translatedNames;

    /**
     * @var Sport[]
     *
     * @Groups({"universe_norm"})
     */
    public $sports = [];

    /**
     * @var bool
     *
     * @Groups({"universe_norm"})
     */
    public $active = true;

    /**
     * @var string
     *
     * @Groups({"universe_norm"})
     */
    public $createdAt;

    /**
     * @var string
     *
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
