<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string     getId()
 * @method void       setId(string $id)
 * @method User       getUser()
 * @method void       setUser(User $user)
 * @method string     getLibelle()
 * @method void       setLibelle(string $libelle)
 * @method null|int   getDistance()
 * @method void       setDistance(?int $distance)
 * @method null|int   getAscendant()
 * @method void       setAscendant(?int $ascendant)
 * @method null|int   getDescendant()
 * @method void       setDescendant(?int $descendant)
 * @method array      getLocations()
 * @method void       setLocations(array $locations)
 * @method null|float getLatitude()
 * @method void       setLatitude(?float $latitude)
 * @method null|float getLongitude()
 * @method void       setLongitude(?float $longitude)
 * @method null|float getElevation()
 * @method void       setElevation(?float $elevation)
 * @method bool       isCorrectedElevation()
 * @method void       setCorrectedElevation(bool $correctedElevation)
 * @method \DateTime  getCreatedAt()
 * @method void       setCreatedAt(\DateTime $createdAt)
 * @method \DateTime  getUpdatedAt()
 * @method void       setUpdatedAt(\DateTime $updatedAt)
 */
class UserRoute extends ProxyObject
{
    /**
     * @var string
     * @Groups({"user_route_norm", "user_route_norm_cget"})
     */
    public $id;
    /**
     * @var User
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    public $user;
    /**
     * @var string
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    public $libelle;
    /**
     * @var ?int
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    public $distance;
    /**
     * @var ?int
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    public $ascendant;
    /**
     * @var ?int
     * @Groups({"user_route_norm", "user_route_norm_cget", "user_route_denorm"})
     */
    public $descendant;
    /**
     * @var array
     * @Groups({"user_route_norm", "user_route_denorm"})
     */
    public $locations;
    /**
     * @var ?float
     * @Groups({"user_route_norm"})
     */
    public $latitude;
    /**
     * @var ?float
     * @Groups({"user_route_norm"})
     */
    public $longitude;
    /**
     * @var ?float
     * @Groups({"user_route_norm"})
     */
    public $elevation;
    /**
     * @var bool
     * @Groups({"user_route_norm"})
     */
    public $correctedElevation;
    /**
     * @var \DateTime
     * @Groups({"user_route_norm", "user_route_norm_cget"})
     */
    public $createdAt;
    /**
     * @var \DateTime
     * @Groups({"user_route_norm", "user_route_norm_cget"})
     */
    public $updatedAt;

    public function __toString()
    {
        return $this->getId();
    }
}
