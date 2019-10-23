<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string      getId()
 * @method void        setId(string $id)
 * @method User        getUser()
 * @method void        setUser(User $user)
 * @method PoiCategory getPoiCategory()
 * @method void        setPoiCategory(PoiCategory $poiCategory)
 * @method null|string getName()
 * @method void        setName(?string $name)
 * @method null|string getDescription()
 * @method void        setDescription(?string $description)
 * @method null|float  getLatitude()
 * @method void        setLatitude(?float $latitude)
 * @method null|float  getLongitude()
 * @method void        setLongitude(?float $longitude)
 * @method \DateTime   getCreatedAt()
 * @method void        setCreatedAt(\DateTime $createdAt)
 * @method \DateTime   getUpdatedAt()
 * @method void        setUpdatedAt(\DateTime $updatedAt)
 */
class UserPoi extends ProxyObject
{
    /**
     * @var string
     *
     * @Groups({"user_poi_norm"})
     */
    public $id;

    /**
     * @var User
     * @Groups({"user_poi_norm", "user_poi_denorm"})
     */
    public $user;

    /**
     * @var PoiCategory
     * @Groups({"user_poi_norm", "user_poi_denorm"})
     */
    public $poiCategory;

    /**
     * @var ?string
     * @Groups({"user_poi_norm", "user_poi_denorm"})
     */
    public $name;

    /**
     * @var ?string
     * @Groups({"user_poi_norm", "user_poi_denorm"})
     */
    public $description;

    /**
     * @var ?float
     * @Groups({"user_poi_norm", "user_poi_denorm"})
     */
    public $latitude;

    /**
     * @var ?float
     * @Groups({"user_poi_norm", "user_poi_denorm"})
     */
    public $longitude;

    /**
     * @var \DateTime
     * @Groups({"user_poi_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"user_poi_norm"})
     */
    public $updatedAt;
}
