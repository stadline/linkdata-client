<?php

declare(strict_types=1);

namespace Stadline\LinkdataClient\Linkdata\Entity;

use Stadline\LinkdataClient\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string           getId()
 * @method void             setId(string $id)
 * @method ?string          getName()
 * @method void             setName(?string $name)
 * @method User             getUser()
 * @method void             setUser(User $user)
 * @method Sport            getSport()
 * @method void             setSport(Sport $sport)
 * @method ?UserDevice      getUserDevice()
 * @method void             setUserDevice(?UserDevice $userDevice)
 * @method \DateTime        getStartdate()
 * @method void             setStartdate(\DateTime $startdate)
 * @method int              getDuration()
 * @method void             setDuration(int $duration)
 * @method ?float           getLatitude()
 * @method void             setLatitude(?float $latitude)
 * @method ?float           getLongitude()
 * @method void             setLongitude(?float $longitude)
 * @method ?float           getElevation()
 * @method void             setElevation(?float $elevation)
 * @method bool             isManual()
 * @method void             setManual(bool $manual)
 * @method ?string          getComment()
 * @method void             setComment(?string $comment)
 * @method ?Connector       getConnector()
 * @method void             setConnector(?Connector $connector)
 * @method ?UserSession     getUserSession()
 * @method void             setUserSession(?UserSession $userSession)
 * @method array            getImages()
 * @method void             setImages(array $images)
 * @method bool             isCorrectedElevation()
 * @method void             setCorrectedElevation(bool $correctedElevation)
 * @method ?string          getThumbnail()
 * @method void             setThumbnail(?string $thumbnail)
 * @method array            getDataSummaries()
 * @method void             setDataSummaries(array $dataSummaries)
 * @method array            getTags()
 * @method void             setTags(array $tags)
 * @method bool             isTrackFlag()
 * @method void             setTrackFlag(bool $trackFlag)
 * @method bool             isDatastreamFlag()
 * @method void             setDatastreamFlag(bool $datastreamFlag)
 * @method ?GlobalChallenge getGlobalChallenge()
 * @method void             setGlobalChallenge(?GlobalChallenge $globalChallenge)
 * @method array            getAvailableDatatypes()
 * @method void             setAvailableDatatypes(array $availableDatatypes)
 * @method array            getLocations()
 * @method void             setLocations(array $locations)
 * @method array            getDatastream()
 * @method void             setDatastream(array $datastream)
 * @method \DateTime        getCreatedAt()
 * @method void             setCreatedAt(\DateTime $createdAt)
 * @method \DateTime        getUpdatedAt()
 * @method void             setUpdatedAt(\DateTime $updatedAt)
 */
class Activity extends ProxyObject
{
    /**
     * @var string
     * @Groups({"activity_norm"})
     */
    public $id;

    /**
     * @var ?string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $name;

    /**
     * @var User
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $user;

    /**
     * @var Sport
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $sport;

    /**
     * @var ?UserDevice
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $userDevice;

    /**
     * @var \DateTime
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $startdate;

    /**
     * @var int
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $duration;

    /**
     * @var ?float
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $latitude;

    /**
     * @var ?float
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $longitude;

    /**
     * @var ?float
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $elevation;

    /**
     * @var bool
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $manual = false;

    /**
     * @var ?string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $comment;

    /**
     * @var ?Connector
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $connector;

    /**
     * @var ?UserSession
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $userSession;

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $images = [];

    /**
     * @var bool
     * @Groups({"activity_norm"})
     */
    public $correctedElevation = false;

    /**
     * @var ?string
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $thumbnail;

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $dataSummaries = [];

    /**
     * @var array
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $tags = [];

    /**
     * @var bool
     * @Groups({"activity_norm"})
     */
    public $trackFlag = false;

    /**
     * @var bool
     * @Groups({"activity_norm"})
     */
    public $datastreamFlag = false;

    /**
     * @var ?GlobalChallenge
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $globalChallenge;

    /**
     * @var array
     * @Groups({"activity_norm"})
     */
    public $availableDatatypes = [];

    /**
     * @var array
     * @Groups({"activity_norm"})
     */
    public $locations = [];

    /**
     * @var array
     * @Groups({"activity_norm"})
     */
    public $datastream = [];

    /**
     * @var \DateTime
     * @Groups({"activity_norm"})
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @Groups({"activity_norm"})
     */
    public $updatedAt;
}
