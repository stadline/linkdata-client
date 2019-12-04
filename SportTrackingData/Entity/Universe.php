<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Annotation\Cache;
use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use SportTrackingDataSdk\ClientHydra\Utils\TranslatedPropertiesTrait;
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
    use TranslatedPropertiesTrait;

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

    public function getNameByLocale(string $locale): ?string
    {
        return $this->getTranslatedPropertyByLocale('translatedNames', $locale);
    }
}
