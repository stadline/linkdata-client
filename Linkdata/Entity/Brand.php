<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Annotation\Cache;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Stadline\LinkdataClient\ClientHydra\Utils\TranslatedPropertiesTrait;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @Cache(
 *     public=true,
 *     ttl=3600,
 * )
 *
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
    use TranslatedPropertiesTrait;

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

    public function getNameByLocale(string $locale): ?string
    {
        return $this->getTranslatedPropertyByLocale('translatedNames', $locale);
    }

    public function __toString(): string
    {
        return (string) $this->getTranslatedNames()['en'];
    }
}
