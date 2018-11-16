<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string      getId()
 * @method void        setId(string $id)
 * @method null|string getName()
 * @method void        setName(null|string $name)
 * @method User        getUser()
 * @method void        setUser(User $user)
 * @method Sport       getSport()
 * @method void        setSport(Sport $sport)
 * @method UserDevice  getUserDevice()
 * @method void        setUserDevice(UserDevice $userDevice)
 * @method \DateTime   getStartdate()
 * @method void        setStartdate(\DateTime $startdate)
 * @method string      getStartstringzone()
 * @method void        setStartstringzone(string $startstringzone)
 * @method int         getDuration()
 * @method void        setDuration(int $duration)
 * @method float       getLatitude()
 * @method void        setLatitude(float $latitude)
 * @method float       getLongitude()
 * @method void        setLongitude(float $longitude)
 * @method float       getElevation()
 * @method void        setElevation(float $elevation)
 * @method bool        isManual()
 * @method void        setManual(bool $manual)
 * @method string      getComment()
 * @method void        setComment(string $comment)
 * @method string      getConnector()
 * @method void        setConnector(string $connector)
 * @method string      getUserSession()
 * @method void        setUserSession(string $userSession)
 * @method array       getImages()
 * @method void        setImages(array $images)
 * @method bool        isCorrectedElevation()
 * @method void        setCorrectedElevation(bool $correctedElevation)
 * @method string      getThumbnail()
 * @method void        setThumbnail(string $thumbnail)
 * @method array       getDataSummaries()
 * @method void        setDataSummaries(array $dataSummaries)
 * @method array       getTags()
 * @method void        setTags(array $tags)
 * @method bool        isTrackFlag()
 * @method void        setTrackFlag(bool $trackFlag)
 * @method bool        isDatastreamFlag()
 * @method void        setDatastreamFlag(bool $datastreamFlag)
 * @method string      getGlobalChallenge()
 * @method void        setGlobalChallenge(string $globalChallenge)
 * @method array       getAvailableDatatypes()
 * @method void        setAvailableDatatypes(array $availableDatatypes)
 * @method string      getCreatedAt()
 * @method void        setCreatedAt(string $createdAt)
 * @method string      getUpdatedAt()
 * @method void        setUpdatedAt(string $updatedAt)
 * @method array       getLocations()
 * @method void        setLocations(array $locations)
 * @method array       getDatastream()
 * @method void        setDatastream(array $datastream)
 * @method array       getEquipments()
 * @method void        setEquipments(array $equipments)
 */
class Activity extends ProxyObject
{
    /**
     * @var string
     *
     * @Groups({"activity_norm"})
     */
    public $id;

    /**
     * @var ?string
     *
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $name;

    /**
     * @var User
     *
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $user;

    /**
     * @var Sport
     *
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $sport;

    /**
     * @var UserDevice
     *
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $userDevice;

    /**
     * @var \DateTime
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $startdate;

    /**
     * @var string
     */
    public $startstringzone;

    /**
     * @var int
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $duration;

    /**
     * @var float
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $latitude;

    /**
     * @var float
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $longitude;

    /**
     * @var float
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $elevation;

    /**
     * @var bool
     */
    public $manual;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $comment;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $connector;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $userSession;

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $images;

    /**
     * @var bool
     * @Groups({"activity_norm"})
     */
    public $correctedElevation;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $thumbnail;

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $dataSummaries;

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $tags;

    /**
     * @var bool
     * @Groups({"activity_norm"})
     */
    public $trackFlag;

    /**
     * @var bool
     * @Groups({"activity_norm"})
     */
    public $datastreamFlag;

    /**
     * @var string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $globalChallenge;

    /**
     * @var array
     * @Groups({"activity_norm"})
     */
    public $availableDatatypes;

    /**
     * @var string
     * @Groups({"activity_norm"})
     */
    public $createdAt;

    /**
     * @var string
     * @Groups({"activity_norm"})
     */
    public $updatedAt;

    /**
     * Temp storage for locations.
     *
     * @var array
     * @Groups({"activity_norm"})
     */
    public $locations;

    /**
     * Temp storage for datastream.
     *
     * @var array
     * @Groups({"activity_norm"})
     */
    public $datastream;

    /**
     * @var array
     * @Groups({"activity_norm"})
     */
    public $equipments;
}