<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use DateTime;
use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string      getId()
 * @method void        setId(string $id)
 * @method User        getUser()
 * @method void        setUser(User $user)
 * @method PoiCategory getPoiCategory()
 * @method void        setPoiCategory(PoiCategory $poiCategory)
 * @method string      getName()
 * @method void        setName(string $name)
 * @method string      getDescription()
 * @method void        setDescription(string $description)
 * @method float       getLatitude()
 * @method void        setLatitude(float $latitude)
 * @method float       getLongitude()
 * @method void        setLongitude(float $longitude)
 * @method DateTime    getCreatedAt()
 * @method void        setCreatedAt(DateTime $createdAt)
 * @method DateTime    getUpdatedAt()
 * @method void        setUpdatedAt(DateTime $updatedAt)
 */
class UserPoi extends ProxyObject
{
    /**
     * @var string
     *
     * @Groups({"user_poi_norm", "user.migration"})
     */
    public $id;

    /**
     * @var User
     *
     * @Groups({"user_poi_norm", "user_poi_denorm", "user.migration"})
     */
    public $user;

    /**
     * @var PoiCategory
     *
     * @Groups({"user_poi_norm", "user_poi_denorm", "user.migration"})
     */
    public $poiCategory;

    /**
     * @var string
     *
     * @Groups({"user_poi_norm", "user_poi_denorm", "user.migration"})
     */
    public $name;

    /**
     * @var string
     *
     * @Groups({"user_poi_norm", "user_poi_denorm", "user.migration"})
     */
    public $description;

    /**
     * @var float
     *
     * @Groups({"user_poi_norm", "user_poi_denorm", "user.migration"})
     */
    public $latitude;

    /**
     * @var float
     *
     * @Groups({"user_poi_norm", "user_poi_denorm", "user.migration"})
     */
    public $longitude;

    /**
     * @var DateTime
     *
     * @Groups({"user_poi_norm", "user.migration"})
     */
    public $createdAt;

    /**
     * @var DateTime
     *
     * @Groups({"user_poi_norm", "user.migration"})
     */
    public $updatedAt;
}
