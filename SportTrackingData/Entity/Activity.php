<?php

declare(strict_types=1);

namespace SportTrackingDataSdk\SportTrackingData\Entity;

use SportTrackingDataSdk\ClientHydra\Proxy\ProxyObject;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @method string               getId()
 * @method void                 setId(string $id)
 * @method null|string          getName()
 * @method void                 setName(?string $name)
 * @method User                 getUser()
 * @method void                 setUser(User $user)
 * @method Sport                getSport()
 * @method void                 setSport(Sport $sport)
 * @method null|UserDevice      getUserDevice()
 * @method void                 setUserDevice(?UserDevice $userDevice)
 * @method \DateTime            getStartdate()
 * @method void                 setStartdate(\DateTime $startdate)
 * @method int                  getDuration()
 * @method void                 setDuration(int $duration)
 * @method null|float           getLatitude()
 * @method void                 setLatitude(?float $latitude)
 * @method null|float           getLongitude()
 * @method void                 setLongitude(?float $longitude)
 * @method null|float           getElevation()
 * @method void                 setElevation(?float $elevation)
 * @method bool                 isManual()
 * @method void                 setManual(bool $manual)
 * @method null|string          getComment()
 * @method void                 setComment(?string $comment)
 * @method null|Connector       getConnector()
 * @method void                 setConnector(?Connector $connector)
 * @method null|UserSession     getUserSession()
 * @method void                 setUserSession(?UserSession $userSession)
 * @method array                getImages()
 * @method void                 setImages(array $images)
 * @method bool                 isCorrectedElevation()
 * @method void                 setCorrectedElevation(bool $correctedElevation)
 * @method null|string          getThumbnail()
 * @method void                 setThumbnail(?string $thumbnail)
 * @method array                getDataSummaries()
 * @method void                 setDataSummaries(array $dataSummaries)
 * @method array                getTags()
 * @method void                 setTags(array $tags)
 * @method bool                 isTrackFlag()
 * @method void                 setTrackFlag(bool $trackFlag)
 * @method bool                 isDatastreamFlag()
 * @method void                 setDatastreamFlag(bool $datastreamFlag)
 * @method null|GlobalChallenge getGlobalChallenge()
 * @method void                 setGlobalChallenge(?GlobalChallenge $globalChallenge)
 * @method array                getAvailableDatatypes()
 * @method void                 setAvailableDatatypes(array $availableDatatypes)
 * @method array                getLocations()
 * @method void                 setLocations(array $locations)
 * @method void                 setDatastream(array $datastream)
 * @method \DateTime            getCreatedAt()
 * @method void                 setCreatedAt(\DateTime $createdAt)
 * @method \DateTime            getUpdatedAt()
 * @method void                 setUpdatedAt(\DateTime $updatedAt)
 * @method array                getEquipments()
 * @method void                 setEquipments(array $equipments)
 * @method void                 addEquipment(UserEquipment $equipment)
 * @method void                 removeEquipment(UserEquipment $equipment)
 * @method null|SubActivity     getSubActivities()
 * @method void                 setSubActivities(?array $subActivity)
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
     * @var GlobalChallenge[]
     * @Groups({"activity_norm"})
     */
    public $globalChallenges;

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
     * @var array
     * @Groups({"activity_norm"})
     */
    public $equipments;

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

    /**
     * @var SubActivity[]
     * @Groups({"activity_norm", "activity_denorm"})
     */
    public $subActivities;

    public function getDatastream()
    {
        if (!$this->isDatastreamFlag()) {
            return [];
        }

        // this line is required to use magic methods to get data
        $datastreamVar = $this->__call('getDatastream', []);

        // Add measure at elapsed_time = 0 if not set (legacy linkdata-bundle)
        if (0 < \count($datastreamVar) && !isset($datastreamVar[0]) && !isset($datastreamVar[1])) {
            $datastreamVar[0] = [Datatype::DISTANCE => 0];
        }
        \ksort($datastreamVar);

        return $datastreamVar;
    }
}
